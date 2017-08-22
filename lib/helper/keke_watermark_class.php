<?php
class keke_watermark_class{
    public $imgPath ;						
    public $imgInfo;						
    public $imgW;							
    public $imgH;							
    public $img;							
    public $waterImgPath;					
    public $waterImg;						
    public $waterImgInfo;					
    public $margin_x=0;					
    public $margin_y=0;					
    public $location='right_down';				
    public $x=0;							
    public $y=0;							
    public $error = array(
        'IMG_NOT_EXISTS'=>'图片不存在',
        'IMG_FORMAT_NOT_ALLOW'=>'图片格式不对',
        'NOT_SET_WATERIMG'=>'没有设置水印图片',
        'WATERIMG_NOT_EXISTS'=>'水印图片不存在',
        'FONTfILE_NOT_EXISTS'=>'字体不存在',
        'WATERIMG_FAILURE'=>'水印图片失败',
    );
    function __construct(){
    }
    public function imgInfo($img){
        $this->imgPath = file_exists($img)?$img:die($this->error['IMG_NOT_EXISTS']);
        $this->imgInfo = getimagesize($this->imgPath);
        $this->imgW = $this->imgInfo[0];
        $this->imgH = $this->imgInfo[1];
        switch ($this->imgInfo[2]) {
            case 3:
                $this->img = imagecreatefrompng($this->imgPath);
                break;
            case 2:
                $this->img = imagecreatefromjpeg($this->imgPath);
                break;
            case 1:
                $this->img = imagecreatefromgif($this->imgPath);
                break;
            default:
                die($this->error['IMG_FORMAT_NOT_ALLOW']);
                break;
        }
    }
    public function imgWaterLocation($w,$h){
        switch ($this->location) {
            case 'left_up':
                $this->x = $this->margin_x;
                $this->y =$this->margin_y;
                break;
            case 'right_up':
                $this->x = $this->imgW-($this->margin_x+$w);
                $this->y = $this->margin_y;
                break;
            case 'right_down':
                $this->x = $this->imgW-($this->margin_x+$w);
                $this->y = $this->imgH-($this->margin_y+$h);
                break;
            case 'left_down':
                $this->x = $this->margin_x;
                $this->y = $this->imgH-($this->margin_y+$h);
                break;
            default:
                $this->x = rand(0,$this->imgW-$w);
                $this->y = rand(0,$this->imgH-$h);
                break;
        }
    }
    private function getWaterImgInfo()
    {
        $this->waterImgPath = $this->waterImgPath;
        $this->waterImgInfo = getimagesize($this->waterImgPath);
        switch ($this->waterImgInfo[2]) {
            case 1:	$this->waterImg = imagecreatefromgif($this->waterImgPath);break;
            case 2: $this->waterImg = imagecreatefromjpeg($this->waterImgPath);break;
            case 3: $this->waterImg = imagecreatefrompng($this->waterImgPath);break;
            default: die("图片类型不支持");break;
        }
    }
    public function ImgWater($waterImg=""){
        if(!empty($waterImg)){
            $this->waterImgPath = $waterImg;
            $this->getWaterImgInfo();
        }
        $waterImgW = $this->waterImgInfo[0];
        $waterImgH = $this->waterImgInfo[1];
        $this->imgWaterLocation($waterImgW,$waterImgH);
        if(!isset($this->waterImg))
            die($this->error['NOT_SET_WATERIMG']);
        $re= imagecopy($this->img,$this->waterImg,$this->x,$this->y,0,0,$waterImgW,$waterImgH);
        if(!$re)	die($this->error['WATERIMG_FAILURE']);
        $this->writeInImg();
    }
    public function writeInImg()
    {
        @unlink($this->imgPath);
        switch($this->imgInfo[2]) {
            case 1:imagegif($this->img,$this->imgPath);break;
            case 2:imagejpeg($this->img,$this->imgPath);break;
            case 3:imagepng($this->img,$this->imgPath);break;
            default: exit($this->error['WATERIMG_FAILURE']);
        }
    }
    public function setLocation($location){
        $this->location = $location;
    }
    public function setMargin($margin_x,$margin_y){
        $this->margin_x = $margin_x;
        $this->margin_y = $margin_y;
    }
    public function setWaterImg($waterImgPath){
        $this->waterImgPath = $waterImgPath;
        $this->getWaterImgInfo();
    }
}
?>