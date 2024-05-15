<?php 
/* 
<div class="menu_mobi_add"></div>
<div class="menu_mobi">
    <p class="menu_baophu"></p>
    <p class="icon_menu_mobi"><i class="fas fa-bars"></i></p>        
    <div class="search-res">
        <p class="transition icon-search"><i class="fa fa-search"></i></p>
        <div class="search-grid w-clear">
            <input type="text" name="keyword2" id="keyword2" placeholder="<?=nhaptukhoatimkiem?>" onkeypress="doEnter(event,'keyword2');"/>
            <p onclick="onSearch('keyword2');"><i class="fa fa-search"></i></p>
        </div>
    </div>
    <!-- <a href="" class="home_mobi"><i class="fa fa-home" aria-hidden="true"></i></a>  -->
</div> 
*/
?>
<div class="menu-res fixed-shadow">
  <div class="menu-bar-res">
    <a id="hamburger" href="#menu" title="Menu"><span></span></a> 
   <div class="menu-bar-res--right">
    <?php 
    /* 
    <a href="" class="logo-mobile">
          <?= $helper->img(UPLOAD_PHOTO_L.$logo['photo'], "logo") ?>
        </a>  
    */
    ?>
     <?php /* 
    <div class="lang-header">
      <a href="ngon-ngu/vi/"><img src="assets/images/vi.png" alt="Tiếng Việt"></a>
      <a href="ngon-ngu/en/"><img src="assets/images/en.png" alt="Tiếng Anh"></a>
    </div> 
    <a data-toggle="modal" class="datlich-small" href="#myModal">
      <?= $helper->img("assets/images/datlich-small.png", "book") ?>
    </a>
      */?> 
    <?php /* 
      <a href="gio-hang" title="<?= giohang ?>" class="mr-1 text-white m-btn-cart">
        <i class="fas fa-shopping-cart"></i></a>
     */?> 
     <div class="search-res">
          <p class="transition icon-search"><i class="fa fa-search"></i></p>
          <div class="search-grid w-clear">
            <input type="text" name="keyword2" id="keyword2" placeholder="{{ __("Tìm kiếm") }}" onkeypress="doEnter(event,'keyword2');"/>
            <p onclick="onSearch('keyword2');"><i class="fa fa-search"></i></p>
          </div>
     </div>  
    </div>  
    <?php 
    /* 
    <span onclick="openNav()" class="js-open-full-nav"><i class="fas fa-bars"></i></span> 
    */
    ?>
  </div>
</div> 