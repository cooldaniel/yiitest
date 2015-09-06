<?php
class SelfApiView extends CWidget
{
	public $doc;
	public $sourceBasePath='framework';
	public $sourceBaseUrl='http://code.google.com/p/yii/source/browse/tags/1.1.7/';
	public $tagName='div';
	public $classHtmlOptions=array('class'=>'summaryTable docClass');
	public $htmlOptions=array();
	
	public $baseScriptUrl;
	public $cssFile;
	
	public function init()
	{
		parent::init();
		if($this->doc===null)
			throw new CException(Yii::t('zii','The "doc" property cannot be empty.'));
	}
	
	public function run()
	{
		$this->registerClientScript();
		$this->renderContent();
	}
	
	public function registerClientScript()
	{
		
	}
	
	// content
	protected function renderContent()
	{
		$this->renderTop();
		$this->renderClass();
		$this->renderProperties();
		//$this->renderMethods();
		//$this->renderPropertiesDetail();
		//$this->renderMethodsDetail();
	}
	
	/* ----- top -----*/
	
	protected function renderTop()
	{
		echo CHtml::tag('h1',array(),$this->doc->name)."\n";
		echo CHtml::openTag('div',array('id'=>'nav'))."\n";
		echo CHtml::link('All Packages','index.html')."\n| ";
		echo CHtml::link('Properties','#properties')."\n| ";
		echo CHtml::link('Methods','#methods')."\n";
		echo CHtml::closeTag('div')."\n";
	}
	
	/* ----- class ----- */
	
	protected function renderClass()
	{
		$class=$this->doc;
		echo CHtml::openTag('table',$this->classHtmlOptions)."\n";
		
		// summary
		echo "<colgroup>\n<col class=\"col-name\" />\n<col class=\"col-value\" />\n</colgroup>\n";
		echo "<tr>\n<th>Package</th>\n<td>{$class->package}</td>\n</tr>\n";
		echo "<tr>\n<th>Inheritance</th>\n<td>".$class->signature.$this->getParentClassesNames($class->parentClasses)."</td>\n</tr>\n";
		echo "<tr>\n<th>Subclasses</th>\n<td>".$this->getSubClassesNames($class->subclasses)."</td>\n</tr>\n";
		echo "<tr>\n<th>Since</th>\n<td>{$class->since}</td>\n</tr>\n";
		echo "<tr>\n<th>Version</th>\n<td>{$class->version}</td>\n</tr>\n";
		//echo "<tr>\n<th>Source Code</th>\n<td>".CHtml::link($this->getSourcePathTitle($class,false),$this->getSourceUrl($class,false),array('class'=>'sourceLink','taget'=>'_blank'))."</td>\n</tr>\n";
		echo CHtml::closeTag('table')."\n\n";
		
		// description
		echo CHtml::tag('div',array('class'=>'classDescription'),$this->resolveDescription($class->description));
	}
	
	public function getParentClassesNames($parentClasses)
	{
		$parentClassesNames='';
		foreach($parentClasses as $parent)
		{
			$parentClassesNames.=" &raquo; <a href=\"{$parent}.html\">{$parent}</a>";
		}
		return $parentClassesNames;
	}
	
	public function getSubClassesNames($subClasses)
	{
		$subClassesNames='';
		foreach($subClasses as $subClass)
		{
			$subClassesNames.="<a href=\"{$subClass}.html\">{$subClass}</a>, ";
		}
		return rtrim($subClassesNames,', ');
	}
	
	/* ----- properties summary ----- */
	
	protected function renderProperties()
	{
		echo CHtml::link('','',array('name'=>'properties'))."\n";
		if($this->doc->publicPropertyCount>0)
			$this->renderPublicProperties();
		if($this->doc->protectedPropertyCount>0)
			$this->renderProtectedProperies();
	}
	
	protected function renderPublicProperties()
	{
		$this->renderPropertyAreaHeader('Public Properties');
		$properties=$this->doc->properties;
		foreach($properties as $name=>$property)
			if(!$property->isProtected)
				$this->renderPropertyItem($property);
		$this->renderPropertyAreaFooter();
	}
	
	protected function renderProtectedProperies()
	{
		$this->renderPropertyAreaHeader('Public Properties');
		$properties=$this->doc->properties;
		foreach($properties as $name=>$property)
			if($property->isProtected)
				$this->renderPropertyItem($property);
		$this->renderPropertyAreaFooter();
	}
	
	protected function renderPropertyAreaHeader($areaTitle)
	{
		echo CHtml::openTag('div',array('class'=>'summary docProperty'))."\n";
		echo CHtml::tag('h1',array(),$areaTitle)."\n";
		echo CHtml::tag('p',array(),CHtml::link('Hide inherited properties','#',array('class'=>'toggle')));
		echo CHtml::tag('table',array('class'=>'summaryTable'));
		echo "<colgroup>\n<col class=\"col-property\" />\n<col class=\"col-type\" />\n<col class=\"col-description\" />\n<col class=\"col-defined\" />\n</colgroup>\n";
		echo "<tr><th>Property</th><th>Type</th><th>Description</th><th>Defined By</th></tr>";
	}
	
	protected function renderPropertyAreaFooter()
	{
		echo Chtml::closeTag('table');
		echo CHtml::closeTag('div');
	}
	
	protected function renderPropertyItem($property)
	{
		$name=$property->name;
		$type=$this->getPropertyType($property->type);
		$introduction=$this->resolveDescription($property->introduction);
		$definedBy=$property->definedBy;
		$rowHtmlOptions=array();
		if($property->isInherited)
			$rowHtmlOptions['class']='inherited';
		
		echo CHtml::openTag('tr',$rowHtmlOptions)."\n";
		echo CHtml::tag('td',array(),CHtml::link($name,"{$definedBy}.html#{$name}-detail"))."\n";
		echo CHtml::tag('td',array(),$type)."\n";
		echo CHtml::tag('td',array(),$introduction)."\n";
		echo CHtml::tag('td',array(),$definedBy)."\n";
		echo CHtml::closeTag('tr')."\n";
	}
	
	/* ----- properties detail ----- */
	
	protected function renderPropertiesDetail()
	{
		$doc=$this->doc;
		if($doc->nativePropertyCount>0)
		{
			echo CHtml::tag('h2',array(),'Property Details')."\n";
			foreach($doc->properties as $property)
				$this->renderPropertyDetail($property);
		}
	}
	
	protected function renderPropertyDetail($property)
	{
		//D::pdhr($property);
		$name=$property->name;
		$readOnlyText=$property->readOnly?' <em>read-only</em>':'';
		$sinceText=($since=$property->since)===null?'':" (available since v{$since})";
		$accessType=$this->resolveAccessType($property);
		$type=$this->getPropertyType($property->type);
		$definedBy=$property->definedBy;
		$noGetterAndSetter=true;
		
		// detail header
		echo CHtml::openTag('div',array('class'=>'detailHeader','id'=>"{$name}-detail"))."\n{$name}\n";
		echo CHtml::tag('span',array('class'=>'detailHeaderTag'),"property{$readOnlyText}{$sinceText}")."\n";
		echo CHtml::closeTag('div')."\n";
		
		// signature
		echo CHtml::openTag('div',array('class'=>'signature'))."\n";
		if($property->getter!==null)
		{
			$noGetterAndSetter=false;
			$getter=$property->getter->name;
			echo "{$accessType} {$type} ".CHtml::link("<b>$getter</b>","{$definedBy}.html#{$getter}")."()<br/>\n";
		}
		if($property->setter!==null)
		{
			$noGetterAndSetter=false;
			$setter=$property->setter->name;
			echo "{$accessType} vaid ".CHtml::link("<b>$setter</b>","{$definedBy}.html#{$setter}")."({$type} \$value)\n";
		}
		if($noGetterAndSetter)
		{
			echo "{$accessType} {$type} \${$name}\n";
		}
		echo CHtml::closeTag('div')."\n";
		
		//description
		echo $this->renderDescription($property->description)."\n";
	}
	
	/* ----- methods summary ----- */
	
	protected function renderMethods()
	{
		echo CHtml::link('','',array('name'=>'methods'));
		if($this->doc->publicMethodCount>0)
			$this->renderPublicMethods();
		if($this->doc->protectedMethodCount>0)
			$this->renderProtectedMethods();
	}
	
	protected function renderPublicMethods()
	{
		$this->renderMethodAreaHeader('Public Methods');
		$methods=$this->doc->methods;
		foreach($methods as $name=>$method)
			if(!$method->isProtected)
				$this->renderMethodItem($method);
		$this->renderMethodAreaFooter();
	}
	
	protected function renderProtectedMethods()
	{
		$this->renderMethodAreaHeader('Protected Methods');
		$methods=$this->doc->methods;
		foreach($methods as $name=>$method)
			if($method->isProtected)
				$this->renderMethodItem($method);
		$this->renderMethodAreaFooter();
	}
	
	protected function renderMethodAreaHeader($areaTitle)
	{
		echo CHtml::openTag('div',array('class'=>'summary docMethod'));
		echo CHtml::tag('h1',array(),$areaTitle)."\n";
		echo CHtml::tag('p',array(),CHtml::link('Hide inherited methods','#',array('class'=>'toggle')));
		echo CHtml::tag('table',array('class'=>'summaryTable'));
		echo "<colgroup>\n<col class=\"col-method\" />\n<col class=\"col-description\" />\n<col class=\"col-defined\" />\n</colgroup>\n";
		echo "<tr><th>Property</th><th>Description</th><th>Defined By</th></tr>";
	}
	
	protected function renderMethodAreaFooter()
	{
		$this->renderPropertyAreaFooter();
	}
	
	protected function renderMethodItem($method)
	{
		//D::pde($method->sourcePath);
		$name=$method->name;
		$definedBy=$this->resolveDefinedBy($method);
		$introduction=$this->resolveDescription($method->introduction);
		$rowHtmlOptions=array('id'=>$name);
		if($method->isInherited)
			$rowHtmlOptions['class']='inherited';
		
		echo CHtml::openTag('tr',$rowHtmlOptions)."\n";
		//echo CHtml::tag('td',array(),CHtml::link($name,"{$definedBy}.html#{$name}-detail"))."\n";
		echo CHtml::tag('td',array(),CHtml::link($name,"{$method->definedBy}.html#{$name}-detail"))."\n";
		echo CHtml::tag('td',array(),$introduction)."\n";
		echo CHtml::tag('td',array(),$definedBy)."\n";
		echo CHtml::closeTag('tr')."\n";
	}
	
	/* ----- methods detail ----- */
	
	protected function renderMethodsDetail()
	{
		$doc=$this->doc;
		if($doc->nativeMethodCount>0)
		{
			echo CHtml::tag('h2',array(),'Method Details')."\n";
			foreach($this->doc->methods as $method)
				if($method->definedBy===$this->doc->name)
					$this->renderMethodDetail($method);
		}
	}
	
	protected function renderMethodDetail($method)
	{
		$name=$method->name;
		$sinceText=($since=$method->since)===null?'':" (available since v{$since})";
		$accessType=$this->resolveAccessType($method);
		
		/* ----- detail header ----- */
		echo CHtml::openTag('div',array('class'=>'detailHeader','id'=>"{$name}-detail"))."\n{$name}()";
		echo CHtml::tag('span',array('class'=>'detailHeaderTag')," method{$sinceText}")."\n";
		echo CHtml::closeTag('div')."\n";
		
		/* ----- summary ----- */
		echo CHtml::openTag('table',array('class'=>'summaryTable'))."\n";
		// snigature
		$signature=$method->signature;
		echo CHtml::openTag('tr',array())."\n";
		echo CHtml::openTag('td',array('colspan'=>3))."\n";
		echo CHtml::tag('div',array('class'=>'signature2'),$signature)."\n";
		echo CHtml::closeTag('td')."\n";
		echo CHtml::closeTag('tr')."\n";
		// params
		if($method->input!==null)
			$this->renderMethodInput($method->input);
		if($method->output!==null)
			$this->renderMethodOutput($method->output);
		echo CHtml::closeTag('table')."\n\n";
		// source code
		$this->renderMethodSourceCode($method)."\n\n";
		// description
		echo $this->renderDescription($method->description)."\n\n";
	}
	
	protected function renderMethodInput($input)
	{
		foreach($input as $item)
		{
			echo CHtml::openTag('tr',array())."\n";
			echo CHtml::tag('td',array('class'=>'paramNameCol'),$item->name)."\n";
			echo CHtml::tag('td',array('class'=>'paramTypeCol'),$item->type)."\n";
			echo CHtml::tag('td',array('class'=>'paramDescCol'),$item->description)."\n";
			echo CHtml::closeTag('tr')."\n";
		}
	}
	
	protected function renderMethodOutput($output)
	{
		echo CHtml::openTag('tr',array())."\n";
		echo CHtml::tag('td',array('class'=>'paramNameCol'),'{return}')."\n";
		echo CHtml::tag('td',array('class'=>'paramTypeCol'),$output->type)."\n";
		echo CHtml::tag('td',array('class'=>'paramDescCol'),$output->description)."\n";
		echo CHtml::closeTag('tr')."\n";
	}
	
	protected function renderMethodSourceCode($method)
	{
		 $line=$method->startLine;
		 $code=$this->getSourceCode($method);
		 // code header
		 echo CHtml::openTag('div',array('class'=>'sourceCode'))."\n";
		 echo CHtml::tag('b',array(),'Source Code:')."\n";
		 echo CHtml::link($this->getSourcePathTitle($method),$this->getSourceUrl($method),array('class'=>'sourceLink'))."\n(";
		 echo CHtml::tag('b',array(),CHtml::link('show','#',array('class'=>'show'))).')'."\n";
		 // code
		 echo CHtml::tag('div',array('class'=>'code'),"\n{$code}\n")."\n";
		 echo CHtml::closeTag('div')."\n";
	}
	
	/* ----- common methods ----- */
	
	protected function getSourceUrl($object,$renderLine=true)
	{
		$base=$this->sourceBaseUrl.$this->sourceBasePath;
		$line=$object->startLine;
		if(!$renderLine)
			$line=null;
		return $object->getSourceUrl($base,$line);
	}
	
	protected function getSourcePathTitle($object,$renderLine=true)
	{
		$sourcePathTitle=$this->sourceBasePath.$object->sourcePath;
		if($renderLine&&($line=$object->startLine)!==null)
			$sourcePathTitle.='#'.$line;
		return $sourcePathTitle;
	}
	
	protected function getSourceCode($object)
	{
		 $code=$object->getSourceCode();
		 //$code=preg_replace('//','',$code);
		 $code=highlight_string("<?php {$code} ?>",true);
		 $code=preg_replace('/&lt;\?php&nbsp;([\s\S]*?)\?&gt;/','\\1',$code);
		 return $code;
	}
	
	protected function resolveDefinedBy($object)
	{
		$definedBy=$object->definedBy;
		if($definedBy===$this->doc->name)
			return $definedBy;
		else
			return CHtml::link($definedBy,"{$definedBy}.html");
	}
	
	protected function resolveAccessType($object)
	{
		if($object->isProtected)
			return 'protected';
		else
			return 'public';
	}
	
	protected function getPropertyType($type)
	{
		return class_exists($type,false)?CHtml::link($type,$type.'.html'):$type;
	}
	
	protected function renderDescription($description)
	{
		if($description===null)
			return '';
		else
			return CHtml::tag('p',array(),$this->resolveDescription($description));
	}
	
	protected function resolveDescription($description)
	{
		// property
		$description=preg_replace_callback('/\{\{(\w+)::(\w+)(\|(\w+))\}\}/',array($this,'specifyOwner'),$description);
		// method
		$description=preg_replace_callback('/\{\{(\w+)::(\w+)(\|(\w+\(\)))\}\}/',array($this,'specifyOwner'),$description);
		// owner
		//$description=preg_replace_callback('/(\w+)::(\w+)|(\w+\(\))/',array($this,'specify'),$description);
		return $description;
	}
	
	protected function specifyOwner($matches)
	{
		$name=$this->doc->name;
		if($matches[1]===$name)
			return CHtml::link($matches[4],"{$name}.html#{$matches[2]}");
		else
			return CHtml::link($matches[1].'::'.$matches[4],"{$name}.html#{$matches[2]}");
	}
	
	protected function specify($matches)
	{
		
	}
}
?>