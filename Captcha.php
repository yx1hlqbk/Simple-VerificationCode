<?php

/**
 *
 */
class Captcha
{
    /**
     * 預設圖片寬
     */
    private $imgWidth = 125;

    /**
     * 預設圖片高
     */
    private $imgHeight = 35;

    /**
     * 亂數列表
     */
    private $randString = 'ABCDEFGHJKLMNPQRSTWXYZ23456789ABCDEFGHJKLMNPQRSTWXYZ3456789';

    /**
     * 亂數字數
     */
    private $countWord;

    /**
     * 亂數
     */
    private $word;

    /**
     * 大小
     */
    private $size = 18;

    /**
     * 亂數產生
     *
     * @return String
     */
    public function randWord()
    {
        $this->countWord = rand(3, 4);
        $countRand = strlen($this->randString) - 1;
        $randString = str_shuffle($this->randString);

        for ($i = 0; $i < $this->countWord; $i ++) {
            $this->word .= $randString[rand(0, $countRand)];
        }

        return $this->word;
    }

    /**
     * 產生圖形
     */
    public function create()
    {
        header("Content-type: image/PNG");
        $image = imagecreate($this->imgWidth, $this->imgHeight);
        $backgroundColor = imagecolorallocate($image, 255, 255, 255);
        $red = imagecolorallocate($image, 200, 200, 200);

        //邊框 上下左右
        imagefill($image, 0, 0, $backgroundColor);
        imageline($image, 0, 0, $this->imgWidth, 0, $red);

        imageline($image, 0, 1, $this->imgWidth, 1, $red);
        imageline($image, 0, $this->imgHeight - 1, $this->imgWidth, $this->imgHeight - 1, $red);
        imageline($image, 0, $this->imgHeight - 2, $this->imgWidth, $this->imgHeight - 2, $red);

        imageline($image, 0, 0, 0, $this->imgHeight, $red);
        imageline($image, 1, 0, 1, $this->imgHeight, $red);

        imageline($image, $this->imgWidth - 1, 0, $this->imgWidth - 1, $this->imgHeight, $red);
        imageline($image, $this->imgWidth - 2, 0, $this->imgWidth - 2, $this->imgHeight, $red);

        for ($i = 0; $i < strlen($this->word); $i++) {
            $font_color = imagecolorallocate($image, $this->randColor(), $this->randColor(), $this->randColor());
            imagestring($image, $this->size, $this->randWidth($i), $this->imgHeight - $this->randHeight(), $this->word[$i], $font_color);
        }

        imagepng($image);
    }

    /**
     * 隨機顏色
     *
     * @return Int
     */
    private function randColor()
    {
        return rand(0, 125);
    }

    /**
     * 隨機寬度
     *
     * @return Int
     */
    private function randWidth($num)
    {
        $start = (int)($this->imgWidth / $this->countWord) * $num + 5;
        $end = (int)($this->imgWidth / $this->countWord) * ($num + 1) - 20;

        return rand($start, $end);
    }

    /**
     * 隨機高度
     *
     * @return Int
     */
    private function randHeight()
    {
        return rand(20, 30);
    }
}
