
<style>
    .main div{
        margin:10px auto;
    }
    .main span.title{
        display:inline-block;
        width:100px;
        text-align:right;
        font-weight:bold;
        margin-right:10px;
    }
    .main .block_row{
        border:1px solid grey;
    }
    .main .block_support_order_all{
        border:1px solid red;
    }
    .main .block_support_order{
        border:1px solid orange;
    }
    .main .block_support_stone{
        border:1px solid yellowgreen;
    }
    .main .block_pay_method{
        border:1px solid green;
    }
</style>

<?php

$item_sku = [
    0=>'无sku',
    1=>'有sku',
    2=>'有sku及金料',
];

$item_price_type = [
    0=>'按规格报价',
    1=>'按数量报价',
];

$item_price_method = [
    0=>'按件报价',
    1=>'折扣供货',
    2=>'金工石',
    3=>'定制BOM',
];

$item_support_order = [
    0=>'不支持',
    1=>'支持',
];

$item_support_stone = [
    0=>'不支持',
    1=>'支持',
];

$item_order_type = [
    0=>'配证书货',
    1=>'配散货',
    2=>'客来石（证书货）',
    3=>'客来石（散货）',
];

$item_stone_type = [
    0=>'圆形',
    1=>'公主方',
    2=>'方形',
];

$item_supply_mode = [
    0=>'现货',
    1=>'订货',
];

$item_pay_method = [
    0=>'现结价',
    1=>'来料加工',
];

class ProductModel
{
    /**
     * 报价方式：1-按规格报价 2-按数量报价.
     */
    const PRICE_TYPE_SPEC = 1;
    const PRICE_TYPE_QTY = 2;

    /**
     * 计价方式：1-按件标价 2-折扣供货 3-金工石 4-定制BOM.
     */
    const PRICE_METHOD_ITEM = 1;
    const PRICE_METHOD_DISCOUNT = 2;
    const PRICE_METHOD_MATERIAL = 3;
    const PRICE_METHOD_BOM = 4;

    /**
     * 是否支持定制：0-不支持 1-支持.
     */
    const IS_SUPPORT_ORDER_NO = 0;
    const IS_SUPPORT_ORDER_YES = 1;

    /**
     * 是否支持选石：0-不支持 1-支持.
     */
    const IS_SUPPORT_STONE_NO = 0;
    const IS_SUPPORT_STONE_YES = 1;

    /**
     * 是否支持刻字：0-不支持 1-支持.
     */
    const IS_SUPPORT_WORD_NO = 0;
    const IS_SUPPORT_WORD_YES = 1;

    /**
     * 是否一口价：0-否 1-是.
     */
    const IS_FIXED_PRICE_NO = 0;
    const IS_FIXED_PRICE_YES = 1;

    /**
     * 供货方式：1-现货 2-订货生产.
     */
    const SUPPLY_MODE_STOCK = 1;
    const SUPPLY_MODE_BOOK = 2;

    /**
     * 支持的结算方式: 1-现结价(全款结算) 2-来料加工（不收材料费，只收加工等其它费用）.
     */
    const PAY_METHOD_ALL = 1;
    const PAY_METHOD_PROCESS = 2;

    /**
     * 详情类型: 1-图文详情 2-多图详情.
     */
    const DESC_TYPE_NORMAL = 1;
    const DESC_TYPE_PICLIST = 2;

    public static $price_type_data = [
        self::PRICE_TYPE_SPEC => '按规格报价',
        self::PRICE_TYPE_QTY => '按数量报价',
    ];

    public static $price_method_data = [
        self::PRICE_METHOD_ITEM => '按件标价',
        self::PRICE_METHOD_DISCOUNT => '折扣供货',
        self::PRICE_METHOD_MATERIAL => '金工石',
        self::PRICE_METHOD_BOM => '定制BOM',
    ];

    public static $support_word_data = [
        self::IS_SUPPORT_WORD_YES => '支持',
        self::IS_SUPPORT_WORD_NO => '不支持',
    ];

    public static $support_order_data = [
        self::IS_SUPPORT_ORDER_YES => '支持',
        self::IS_SUPPORT_ORDER_NO => '不支持',
    ];

    public static $support_stone_data = [
        self::IS_SUPPORT_STONE_YES => '支持',
        self::IS_SUPPORT_STONE_NO => '不支持',
    ];

    public static $fixed_price_data = [
        self::IS_FIXED_PRICE_YES => '是',
        self::IS_FIXED_PRICE_NO => '否',
    ];

    public static $supply_mode_data = [
        self::SUPPLY_MODE_STOCK => '现货',
        self::SUPPLY_MODE_BOOK => '订货生产',
    ];

    public static $pay_method_data = [
        self::PAY_METHOD_ALL => '现结价',
        self::PAY_METHOD_PROCESS => '来料加工',
    ];

    public static $desc_type_data = [
        self::DESC_TYPE_NORMAL => '图文详情',
        self::DESC_TYPE_PICLIST => '多图详情',
    ];

    public static $diamond_shape_data = [
        "Round" => "圆形",
        "Princess" => "公主方",
        "Heart" => "心形",
        "Cushion" => "垫形",
        "Oval" => "椭圆",
        "Pear" => "梨形",
        "Radiant" => "雷迪恩",
        "Emerald" => "祖母绿",
        "Triangle" => "三角形",
        "Marquise" => "马眼形",
        "Other" => "其他",
    ];

    /**
     * sku类型（0-没有sku 1-有sku 2-有SKU及金重）.
     */
    const SKU_TYPE_NO_SKU = 0;
    const SKU_TYPE_HAS_SKU = 1;
    const SKU_TYPE_HAS_SKU_GOLDWEIGHT = 2;

    public static $skuTypeList = [
        self::SKU_TYPE_NO_SKU => '没有sku',
        self::SKU_TYPE_HAS_SKU => '有sku',
        self::SKU_TYPE_HAS_SKU_GOLDWEIGHT => '有sku及金重',
    ];
}

// 从列表中筛选
const TYPE_PICKUP_FROM_LIST = 1;

// 对于上级选中值，针对给定的对象列表进行处理 -- 可以针对选择的不同值，分别定义不同的列表
// 只有和当前值相等的列表才会被执行
const TYPE_TOGGLE = 2;

// 对于上级选中值，针对给定的对象列表进行处理 -- 可以针对选择的不同值，分别定义不同的列表
// 所有列表都会被执行
// 缺陷：如果不同值定义的列表不是彼此互斥的，后面执行的操作，会覆盖前面的操作
const TYPE_MULTI = 3;

const ALLOW_NO = 0;
const ALLOW_YES = 1;

// 通过配置映射的方式，自动生成html区块结构和js脚本
$map = [
    // 内容区类名
    'context_class'=>'.main',
    // 映射项
    'items'=>[

        // sku类型
        '.item_sku'=>[
            // 挑选
            TYPE_PICKUP_FROM_LIST=>[
                // 挑选 计价方式
                '.item_price_method'=>[
                    'default'=>['allow'=>[0,1,2,3], 'exclude'=>false],
                    ProductModel::SKU_TYPE_NO_SKU=>['allow'=>[3]],
                    ProductModel::SKU_TYPE_HAS_SKU=>['allow'=>[0,1,3]],
                    ProductModel::SKU_TYPE_HAS_SKU_GOLDWEIGHT=>['allow'=>[0,1,2,3]],
                ],
            ],
            // 切换
            TYPE_TOGGLE=>[
                // 切换 定制 区块
                '.block_support_order_all'=>[
                    'default'=>['allow'=>[ALLOW_YES], 'exclude'=>false],
                    ProductModel::SKU_TYPE_NO_SKU=>['allow'=>[ALLOW_YES]],
                    ProductModel::SKU_TYPE_HAS_SKU=>['allow'=>[ALLOW_NO]],
                    ProductModel::SKU_TYPE_HAS_SKU_GOLDWEIGHT=>['allow'=>[ALLOW_NO]],
                ],
                // 切换 供货方式 区块
                '.block_supply_mode'=>[
                    'default'=>['allow'=>[ALLOW_YES], 'exclude'=>false],
                    ProductModel::SKU_TYPE_NO_SKU=>['allow'=>[ALLOW_NO]],
                    ProductModel::SKU_TYPE_HAS_SKU=>['allow'=>[ALLOW_YES]],
                    ProductModel::SKU_TYPE_HAS_SKU_GOLDWEIGHT=>['allow'=>[ALLOW_YES]],
                ],
            ],
        ],
        // 报价方式
        '.item_price_type'=>[
            // 切换
            TYPE_TOGGLE=>[
                // 切换 计价方式 区块
                '.block_price_method'=>[
                    'default'=>['allow'=>[ALLOW_YES], 'exclude'=>false],
                    ProductModel::PRICE_TYPE_SPEC=>['allow'=>[ALLOW_YES]],
                    ProductModel::PRICE_TYPE_QTY=>['allow'=>[ALLOW_NO]],
                ],
            ],
        ],
    ],
];

?>

<div class="main">

    <div class="item_row item_sku">
        <span class="title">sku类型</span>
        <?php echo CHtml::radioButtonList('item_sku', ProductModel::SKU_TYPE_NO_SKU, ProductModel::$skuTypeList, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
    </div>

    <div class="item_row item_price_type">
        <span class="title">报价方式</span>
        <?php echo CHtml::radioButtonList('item_price_type', ProductModel::PRICE_TYPE_SPEC, ProductModel::$price_type_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
    </div>

    <div class="block_row block_price_method">

        <div class="item_row item_price_method">
            <span class="title">计价方式</span>
            <?php echo CHtml::radioButtonList('item_price_method', ProductModel::PRICE_METHOD_ITEM, ProductModel::$price_method_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
        </div>

    </div>

    <div class="block_row block_support_order_all">

        <div class="item_row item_support_order">
            <span class="title">定制</span>
            <?php echo CHtml::radioButtonList('item_support_order', ProductModel::IS_SUPPORT_ORDER_NO, ProductModel::$support_order_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
        </div>

        <div class="block_row block_support_order">

            <div class="item_row item_support_stone">
                <span class="title">选石</span>
                <?php echo CHtml::radioButtonList('item_support_stone', ProductModel::IS_SUPPORT_STONE_NO, ProductModel::$support_stone_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
            </div>

            <div class="block_row block_support_stone">

                <div class="item_row item_order_type">
                    <span class="title">订货类型</span>
                    <?php echo CHtml::radioButtonList('item_order_type', 0, $item_order_type, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
                </div>

                <div class="item_row item_stone_type">
                    <span class="title">石头形状</span>
                    <?php echo CHtml::radioButtonList('item_stone_type', "Round", ProductModel::$diamond_shape_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
                </div>

            </div>

        </div>

    </div>

    <div class="block_row block_supply_mode">

        <div class="item_row item_supply_mode">
            <span class="title">供货方式</span>
            <?php echo CHtml::radioButtonList('item_supply_mode', ProductModel::SUPPLY_MODE_STOCK, ProductModel::$supply_mode_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
        </div>

        <div class="block_row block_pay_method">

            <div class="item_row item_pay_method">
                <span class="title">加工类型</span>
                <?php echo CHtml::radioButtonList('item_pay_method', ProductModel::PAY_METHOD_ALL, ProductModel::$pay_method_data, ['separator'=>'', 'template'=>'<span>{input} {label}</span>']); ?>
            </div>

        </div>

    </div>

</div>

<script>
$(function () {
    var $item_sku = $("input[name='item_sku']");
    var $item_price_type = $("input[name='item_price_type']");
    var $item_price_method = $("input[name='item_price_method']");
    var $item_support_order = $("input[name='item_support_order']");
    var $item_support_stone = $("input[name='item_support_stone']");
    var $item_order_type = $("input[name='item_order_type']");
    var $item_stone_type = $("input[name='item_stone_type']");
    var $item_supply_mode = $("input[name='item_supply_mode']");
    var $item_pay_method = $("input[name='item_pay_method']");

    var $block_support_order_all = $(".block_support_order_all");
    var $block_support_order = $(".block_support_order");
    var $block_support_stone = $(".block_support_stone");
    var $block_supply_mode = $(".block_supply_mode");
    var $block_pay_method = $(".block_pay_method");
    var $block_price_method = $(".block_price_method");

    var $item_sku_price_method_map = {
        "default":["1","2","3","4"],
        "0":["4"],
        "1":["1","2","4"],
        "2":["1","2","3","4"]
    };

    $(".item_sku").on("change", function () {
        switch_item_price_method_by_sku();
        switch_block_supply_order_all_by_sku();
        switch_block_supply_mode_by_sku();
    });

    $(".item_price_type").on("change", function () {
        switch_block_price_method_by_price_type();
    });

    $(".item_support_order").on("change", function () {
        switch_block_support_order_by_support_order();
    });

    $(".item_support_stone").on("change", function () {
        switch_block_support_order_by_support_stone();
    });
    
    init();
    
    function init() {

        // 切换 计价方式 列表
        switch_item_price_method_by_sku();
        // 切换 计价方式 区块
        switch_block_price_method_by_price_type();
        // 切换 定制 区块
        switch_block_support_order_by_support_order();
        // 切换 选石 区块
        switch_block_support_order_by_support_stone();
        // 切换 供货方式 区块
        switch_block_supply_mode_by_sku();
    }
    
    function switch_block_supply_order_all_by_sku() {
        switchContainer($item_sku, {
            "0": $block_support_order_all
        });
    }
    
    function switch_block_supply_mode_by_sku() {
        console.log(111);
        switchContainer($item_sku, {
            "1": $block_supply_mode,
            "2": $block_supply_mode
        });
    }

    function switch_block_support_order_by_support_stone() {
        switchContainer($item_support_stone, {
            "1": $block_support_stone
        });
    }
    
    function switch_block_support_order_by_support_order() {
        switchContainer($item_support_order, {
            "1": $block_support_order
        });
    }

    function switch_block_price_method_by_price_type() {
        switchContainer($item_price_type, {
            "1": $block_price_method
        });
    }
    
    function switch_item_price_method_by_sku() {
        switchContainer($item_sku, {}, function (val) {
            var map = $item_sku_price_method_map[val];
            if (!map) {
                map = $item_sku_price_method_map.default;
            }
            filterList($item_price_method, map);
        });
    }

    function filterList($target, include) {

        if(typeof $target == "string") {
            $target = $('input[name="' + $target + '"]');
        }

        // 过滤列表
        $target.each(function () {
            var self = $(this);
            if (inArray(self.val(), include)) {
                self.closest("span").show();
            } else {
                self.closest("span").hide();
            }
        });

        // 自动选中效果 - 过滤后列表没有可见的选中项时，选中第一项
        if (!$target.filter(":visible").filter(":checked").val()) {
            checked($target.filter(":visible").first()).trigger("click");
        }
    }

    function unchecked(obj) {
        return checked(obj, true);
    }
    
    function checked(obj, unchecked) {
        if (unchecked) {
            obj.prop("checked", "");
        } else {
            obj.prop("checked", "checked");
        }
        return obj;
    }

    function inArray(val, include) {
        var found = false;
        for (var i=0; i<include.length; i++) {
            if (val == include[i]) {
                found = true;
                break;
            }
        }
        return found;
    }

    // 缺陷：当map的操作列表是彼此互斥时才有效，否则后面的效果将会覆盖前面的效果，
    // 因为列表中的每一项总是会被执行
    function switchContainer ($target, map, callback) {
        var val;

        if(typeof $target == "string") {
            $target = $('input[name="' + $target + '"]');
        }

        val = $target.filter(":checked").val();

        for(var pro in map) {
            console.log(pro, val);
//            map[pro] = $(map[pro]).hide();
//
//            if(pro == val) {
//                map[pro].show();
//            }

            // 使得可以同时执行多个对象处理
            byarray(pro, val, map[pro]);
        }

        if($.isFunction(callback)) {
            callback(val);
        }
    }

    function byarray(val1, val2, item) {

        if (typeof item == "array") {
            for (var i=0; i<=item.length; i++) {
                var obj = $(item[i]).hide();

                if (val1 == val2) {
                    obj.show();
                }
            }
        } else {
            item = $(item).hide();

            if (val1 == val2) {
                item.show();
            }
        }
    }
});
</script>