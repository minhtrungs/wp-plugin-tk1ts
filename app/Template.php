<?php
class TLP_Template
{
    public $template_list = [
        'register.php'      =>  'Tạo người dùng',
        'logout.php'        =>  'Đăng xuất',
        'form.php'          =>  "Form nhập liệu",
        'print.php'         =>  "Print",
        'password.php'      =>  "Đổi mật khẩu",
    ];

    public function handle(){
        add_filter( 'theme_page_templates', array( $this, 'create_template' ), 1 );
        add_filter ('page_template', array( $this, 'use_template' ), 2 );
    }

    public function create_template($templates){
        $template_list = $this->template_list;
        foreach($template_list as $file => $name){
            $templates[$file] = $name;
        }
        return $templates;
    }

    public function use_template($template){
        $template_list = $this->template_list;
        foreach($template_list as $file => $name){
            if(is_page_template($file)){
                TLP_Frontend::render();
                $template = dirname( __FILE__ ) . '/templates/' . $file;
                return $template;
            }
        }
    }
}