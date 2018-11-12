<?php




/****************************************** 内核主程序 ********************************/

/**
BIOS的主要功能概括来说包括如下几部分：
1）POST
加电自检，检测CPU各寄存器、计时芯片、中断芯片、DMA控制器等
2）Initial
枚举设备，初始化寄存器，分配中断、IO端口、DMA资源等
3）Setup
进行系统设置，存于CMOS中。一般开机时按Del或者F2进入到BIOS的设置界面。
4）常驻程序
INT 10h、INT 13h、INT 15h等，提供给操作系统或应用程序调用。
5）启动自举程序
在POST过程结束后，将调用INT 19h，启动自举程序，自举程序将读取引导记录，装载操作系统。

下面是内核主程序执行流程.
*/

// 初始化内核主程序
init_kernel();

// 创建进程表数据对象
$process_list = create_process_list();

// 初始化进程状态队列
$process_queue_runable = []; // 就绪队列
$process_queue_blocked = []; // 阻塞队列：等待事件来完成
$process_queue_blocked_suspended = []; // 挂起/暂停队列：被交换到磁盘，阻塞挂起
$process_queue_runable_suspended = []; // 挂起/暂停队列：被交换到磁盘，就绪挂起

// 根据系统配置，创建进程列表
$config_list = '/etc/rc.d/*';
create_process_list_on_config($config_list);

// 进程调度
process_schedule();





/********************************************* 创建进程列表 **************************************/

// 初始化内核主程序
function init_kernel()
{

}

// 创建进程表数据对象
function create_process_list()
{
    return [];
}

// 根据系统配置，创建进程列表
function create_process_list_on_config_list($config_list)
{
    foreach ($config_list as $config) {
        create_process_list_on_config($config);
    }
}

// 根据系统配置，创建一个进程
function create_process_list_on_config($config)
{
    global $process_list;

    // 创建一个进程
    $process = create_process();

    // 把创建的进程加入到进程表里
    add_process_to_process_list($process_list, $process);

    // 更新进程表的状态队列
    update_process_list_queue($process);
}

// 创建一个进程
function create_process()
{
    return [];
}

// 把创建的进程加入到进程表里
function add_process_to_process_list($process_list, $process)
{
    $process_list[] = $process;
}

// 更新进程表的状态队列
function update_process_list_queue($process)
{
    global $process_queue_runable;
    global $process_queue_blocked;
    global $process_queue_blocked_suspended;
    global $process_queue_runable_suspended;

    // 判断进程状态，更新进程状态队列
    $status = get_process_next_status($process);
    switch ($status) {
        case 'runable':

            // 下一个状态依然是可以执行的
            if ($process['cputime'] > 0) {

                // 已执行的进程放到队列后面
                process_queue_append($process_queue_runable, $process);
            } else {

                // 新创建的进程放到队列前面
                process_queue_prepend($process_queue_runable, $process);
            }
            break;
        case 'blocked':

            // 下一个状态是阻塞的，放到阻塞队列后面
            process_queue_append($process_queue_blocked, $process);
            break;
        case 'blocked_suspended':

            // 下一个状态是阻塞挂起的，放到阻塞挂起队列后面
            process_queue_append($process_queue_blocked_suspended, $process);
            break;
        case 'runable_suspended':

            // 下一个状态是就绪挂起的，放到就绪挂起队列后面
            process_queue_append($process_queue_runable_suspended, $process);
            break;
        default:
            break;
    }
}

// 获取一个进程的状态
function get_process_status($process)
{
    return true;
}

// 获取一个进程下一个状态
function get_process_next_status($process)
{
    return true;
}

function process_queue_append($process_queue, $process)
{

}

function process_queue_prepend($process_queue, $process)
{

}

function process_queue_remove($process_queue, $process)
{

}




/********************************************* 进程调度 **************************************/

// 进程调度
function process_schedule() {

    while (true) {

        // 获取可运行进程
        $process = get_runable_process();

        // 没有可运行的进程时，设置一个信号并阻塞，当有可运行进程时，由信号激活这里继续执行
        if ($process == null) {
            wait_for_runable_process();
        }

        // 记录进程运行之前的信息
        $profileing = [];

        // 设置进程时钟
        set_process_clock($process);

        // 运行进程
        run_process($process);

        // 进程运行之后，更新记录信息
        collection_process_profileing($process, $profileing);

        // cpu时间片到了，或者进程退出时，更新进程基本信息和状态队列
        update_process_info($process, $profileing);

    }

}

// 检查可运行进程队列，有进程的话返回第一个
function get_runable_process()
{
    global $process_queue_runable;

    if (count($process_queue_runable) == 0 ) {
        return null;
    }

    return array_pop($process_queue_runable);
}

// 等待下一个可运行的进程
function wait_for_runable_process()
{

}

// 设置进程时钟
function set_process_clock($process)
{

}

// 运行进程
function run_process($process)
{

}

// 进程运行之后，更新记录信息
function collection_process_profileing($process, &$profileing)
{

}

// cpu时间片到了，或者进程退出时，更新进程基本信息和状态队列
function update_process_info($process, $profileing)
{

}




/********************************************* 中断处理 **************************************/



/** 事件发生时，阻塞进程编程可运行进程 **/
// 通过信号的方式唤醒进程：信号是软件中断
// 中断处理程序，触发对进程的管理
// 参数：中断编号，当前执行的进程
function handle_interrupt($interrupt, $process)
{
    switch ($interrupt) {
        case '6':
            // 非法指令
            break;
        case '8':
            // 定时中断
            break;
        case '9':
            // 键盘中断
            break;
        case '13':
            // 磁盘中断
            break;
        case '15':
            // 程序多任务等中断
            interrupt_multi_service($process, $interrupt);
            break;
        case '19':
            // 激活系统入口
            break;
        default:
            break;
    }
}

// 非法指令
function interrupt_loadall()
{

}

// 定时中断
function interrupt_clock()
{

}

// 键盘中断
function interrupt_keyboard()
{

}

// 磁盘中断
function interrupt_disk()
{

}

// 程序多任务等中断
function interrupt_multi_service($process, $interrupt)
{
    // 从中断控制器获取信号
    $sign = get_sign_from_interrupt($interrupt);

    // 调用进程的信号处理函数
    call_process_sign_list($process, $sign);
}

// 从中断控制器获取信号
function get_sign_from_interrupt($interrupt)
{
    return true;
}

// 调用进程注册的信号处理函数
function call_process_sign_list($process, $sign)
{
    // 判断进程监听的信号列表
    if (!in_array($sign, $process->listen_sign_list)) {
        return null;
    }

    // 依次调用进程注册的信号处理函数
    foreach ($process->sign_handler_list[$sign] as $handler) {
        call_user_func($handler);
    }

    return true;
}