<?php
s_start();
$forms = new clsForms();
$admingiris = new Giris(); 
$kullanicigiris= new Kullanicilar();
if($giris){
    $admingiriskontrol = $admingiris->AdminGirisKontrol($admin,$sifre);
    $kullanicigiriskontrol =$kullanicigiris->KullaniciGirisKontrol($admin,$sifre);
    if($admingiriskontrol){
        s_set('kullanici','admin');
    }if($kullanicigiriskontrol){
        s_set('kullanici',$kullanicigiriskontrol->id);
    }
    else{
        $girishatali ="<div class='error-page'><div class='try-again'>Error: Try again?</div></div>";
    }
}
if($cikis){
    s_unlink("kullanici");
    session_unset();
    $sayfa = "./"; 
    redirect($sayfa);  
    ob_end_flush();
}

if(isset($_SESSION['logincust']) or isset($_SESSION['access_token'])){
    //s_set('kullanici',$_SESSION['logincust']);
    $skullanicivar =$kullanicigiris->SosyalKullaniciGirisKontrol($_SESSION['email']);
    if(isset($skullanicivar->id)){
        $kullanici =$kullanicigiris->KullaniciGetir($skullanicivar->id);
        s_set('kullanici',$kullanici->id);
    }else{
        $randstring =RandomString();
        $kullanici = $kullanicigiris->KullaniciEkle($_SESSION['first_name'].$_SESSION['surname'], $_SESSION['email'], $randstring, $telefon, $birimid, $unvanid, $gorevid);
        s_set('kullanici',$kullanici->id);
    }
}

if(s_get('kullanici')){
?>
<div class="profilecontainer">
<div class="content">
<?php
$kullanici = $kullanicigiris->KullaniciGetir(s_get('kullanici'));
print_r($kullanici);
echo $kullanici->adsoyad;
echo "<br>";
echo $kullanici->email;
echo "<br>";
?>
<a href='./?cikis=1' class="Button">Çıkış </a>
</div>
</div>
<?php
}else{
?><div class="container">
<ul class="accordion css-accordion">
            <li class="accordion-item">
            <input class="accordion-item-input" type="checkbox" name="accordion" id="item1" checked="checked" />
            <label for="item1" class="accordion-item-hd">Üye giriş<span class="accordion-item-hd-cta">&#9650;</span></label>
            <div class="accordion-item-bd">
      <div class="col">
        <a href="./FacebookLogin/loginFB.php" class="fb btn">
            <i class="fa fa-facebook fa-fw"></i> Login with Facebook
         </a>
        <a href="./TwitterLogin/index.php" class="twitter btn">
          <i class="fa fa-twitter fa-fw"></i> Login with Twitter
        </a>
          <a href="./GoogleLogin/index.php" class="google btn"><i class="fa fa-google fa-fw">
          </i> Login with Google+
        </a>
      </div>
  
<form action="./">     
    <div class="col">
     <input type="text" name="admin" placeholder="Username" required>
     <input type="password" name="sifre" placeholder="Password" required>
     <input type="submit"  name ="giris" value="Giriş">
    </div>
</form> 

            </div>
            </li>

            </ul>
</form>      
</div>
<?php } ?>