<?php 
/* 
plugin name: ilk eklentim
plugin uri: http//www.dotnetmcy.com/
description: test eklendim.
version: 0.1
author: Mehmet Cenk Yenikoylu
author uri: http//www.dotnetmcy.com/
*/
add_action("admin_menu","eklentim");
function eklentim(){
    add_menu_page("Eklenti Basligim", "Eklenti Adim", "manage_options", "eklenti-linkim","eklenti_icerigim");

}
function eklenti_icerigim(){
    ?>
    <form method="post"><br/>
        <label>Isim: </label>
        <input type="text" name="isim"></input> <br/>
        <label>eMail: </label>
        <input type="text" name="email"></input> <br/>
        <label>Tel: </label>
        <input type="text" name="tel"></input> <br/>
        <input type="submit"></input>
    </from>
    <?php
    //echo "merhaba dunya";
    //echo $_POST["isim"];
    //add_post_meta(1,"isim","cenker",true);

    // if($_POST){
    //     $ad = $_POST["isim"];
    //     add_post_meta(3,"isim",$ad,true);
    // }


    // if($_POST){
    //     $ad = $_POST["isim"];
    //     $eski_veri = get_post_meta(2,"isim")[0];
    //     update_post_meta(2,"isim",$ad,true);
    // }
    if($_POST){
        if($_POST["isim"] != ""){
            global $wpdb;
            $wpdb->insert("wp_bilgiler7", array(
                "isim"=>$_POST["isim"],
                "eposta"=>$_POST["email"],
                "telefon"=>$_POST["tel"]
            ));
        }
    
    }
}


function veritabani_tablosu_olustur(){

    global $wpdb;
    
    $charset = $wpdb->get_charset_collate();
    $tablo_adi = $wpdb->prefix."bilgiler7";
    
    $sql = "CREATE TABLE $tablo_adi (
        id INT NOT NULL AUTO_INCREMENT ,
        isim VARCHAR(50) NOT NULL,
        eposta VARCHAR(50) NOT NULL,
        telefon VARCHAR(50) NOT NULL,
        UNIQUE KEY id (id)
    ) $charset;
    ";
    
    require_once(ABSPATH. "wp-admin/includes/upgrade.php");
    
    dbDelta($sql);
    
    register_activation_hook(__FILE__, 'creating_plugin_table');//eklentiyi etkinlestirigimiz anda tablo olusturur.
    
}

veritabani_tablosu_olustur();

add_action("admin_menu","kutucuk_ekle");

function kutucuk_ekle(){
    add_meta_box("benim kutum","bilgiler","kutucuk_goster","post","side","high",null);
}
function kutucuk_goster(){
    ?>
          <form method="post"><br/>
    
        <input type="text" name="isim" placeholder="isim giriniz"></input>
       
    </from>
    <?php
}

add_action("save_post","kutucuk_kaydet");

function kutucuk_kaydet(){
    global $wpdb;
            $wpdb->insert("wp_bilgiler7", array(
                "isim"=>$_POST["isim"],
                "eposta"=>"",
                "telefon"=>""
            ));
}

?>