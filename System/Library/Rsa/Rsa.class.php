<?php
namespace System\Library\Rsa;
class Rsa{
    /**
     *
     * @var 公钥
     */
    private $private_key = 'xxx';
    
    /**
     *
     * @var 私钥
     */
    private $public_key =  'xxx';
    
    /**
     * openssl生成rsa的命令 
     * 1.genrsa -out rsa_private_key.pem 1024
     * 2.pkcs8 -topk8 -inform PEM -in rsa_private_key.pem -outform PEM –nocrypt
     * 3.rsa -in rsa_private_key.pem -pubout -out rsa_public_key.pem              
     */
    
    public function index(){
        //echo $private_key;  
        $pi_key =  openssl_pkey_get_private($this->private_key);//这个函数可用来判断私钥是否是可用的，可用返回资源id Resource id  
        $pu_key = openssl_pkey_get_public($this->public_key);//这个函数可用来判断公钥是否是可用的  
        print_r($pi_key);echo "\n";  
        print_r($pu_key);echo "\n";  


        $data = "aassssasssddd";//原始数据  
        $encrypted = "";   
        $decrypted = "";   

        echo "source data:",$data,"\n";  

        echo "private key encrypt:\n";  

        openssl_private_encrypt($data,$encrypted,$pi_key);//私钥加密  
        $encrypted = base64_encode($encrypted);//加密后的内容通常含有特殊字符，需要编码转换下，在网络间通过url传输时要注意base64编码是否是url安全的  
        echo $encrypted,"\n";  

        echo "public key decrypt:\n";  

        openssl_public_decrypt(base64_decode($encrypted),$decrypted,$pu_key);//私钥加密的内容通过公钥可用解密出来  
        echo $decrypted,"\n";  

        echo "---------------------------------------\n";  
        echo "public key encrypt:\n";  

        openssl_public_encrypt($data,$encrypted,$pu_key);//公钥加密  
        $encrypted = base64_encode($encrypted);  
        echo $encrypted,"\n";  

        echo "private key decrypt:\n";  
        openssl_private_decrypt(base64_decode($encrypted),$decrypted,$pi_key);//私钥解密  
        echo $decrypted,"\n";  
    }
}
