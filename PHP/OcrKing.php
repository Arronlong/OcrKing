<?php
/*
*########     [Aven's Lab] (C) 2017 Aven's Lab     ########
*########     Time:        2014-11-03                    ########
*########      File:        GBK OcrKing.php                 ########
*########     Author:   ���Ӿ�   Email: ts@OcrKing.CoM     ########
*########     WebSite:    http://WwW.OcrKing.CoM                ########
*########     ע�⣺��APIΪ��ʱ,�°汾�������ʱ��ͣ�ã�����     ########
*########     ע�⣺ʹ�ô˽ű���Ҫ����php curl��չ��     ########
*########     ע�⣺Ĭ��ʾ����Ҫ����ͼƬ������,��� ����ͼƬ���Ŀ¼ дȨ��     ########
*/

//��ǰ�ű�·��
define ( 'S_ROOT', dirname ( __FILE__ ) . DIRECTORY_SEPARATOR );

/*************************���������������Ҫ�޸�***************************/
//���δ���
error_reporting ( E_ALL || ~ E_NOTICE );

//�����ʼ��ظ������е������滻�����    key
define ( 'API_KEY', 'key' );

//ͼƬ���Ŀ¼
define ( 'DOWN_DIR', S_ROOT . 'down/' );
/*************************���������������Ҫ�޸�***************************/

// ����������
include (S_ROOT .'./class.ocrking.php');


//�����ĵ�˵����ַ https://github.com/AvensLab/OcrKing/blob/master/%E7%BA%BF%E4%B8%8A%E8%AF%86%E5%88%ABhttp%E6%8E%A5%E5%8F%A3%E8%AF%B4%E6%98%8E.txt

// service ʶ�����Ϳ���Ϊ����value�е�ֵ
//<option value="OcrKingForPassages">��ƪ����</option>
//<option value="OcrKingForPDF">PDFʶ��</option>
//<option value="OcrKingForPhoneNumber">�ֻ��绰</option>
//<option value="OcrKingForPrice">�̳Ǽ۸�</option>
//<option value="OcrKingForNumber">��������</option>
//<option value="OcrKingForCaptcha">��֤����</option>
//<option value="BarcodeDecode">���ζ�ά��</option>
//<option value="PDFToImage">PDFתͼƬ</option>


//language ʶ�����ֿ���Ϊ����ֵ  eng(Ӣ��)   sim(����) tra(����)
//<option value="eng">Ӣ ��</option>												
//<option value="sim">�� ��</option>
//<option value="tra">�� ��</option>
//<option value="jpn">�� ��</option>
//<option value="kor">�� ��</option>

// charset ����Ϊ����ѡ�� ,����serviceΪ OcrKingForCaptchaʱ �� language Ϊ eng��Ч�������������Ч
//<option value=""></option>
//<option value="0">����Ӣ���ַ�</option>
//<option value="1">���д�����</option>
//<option value="2">СдӢ����ĸ</option>
//<option value="3">��дӢ����ĸ</option>
//<option value="4">����Сд��ĸ</option>
//<option value="5">���ִ�д��ĸ</option>
//<option value="6">��дСд��ĸ</option>
//<option value="7">���ִ�дСд</option>
//<option value="8">����Ӣ���ַ�</option>
//<option value="9">��ַ���ʼ���</option>
//<option value="10">$���̳Ǽ۸�</option>
//<option value="11">�ֻ��绰����</option>
//<option value="12">��ѧ��ʽ����</option>


//ע��
// ��ʶ������Ϊ�ǳ�ƪ����ʱ ʶ����ֱ�ӷ���
// ��ƪ����ʶ��ʱ����Ϊ���ҳ���url��ַ
//�˽ӿ�֧�����й��ܣ�֧�������ĵ�ʶ��
//Ҳ֧�ֱ���ͼƬʶ��
//�����ļ�urlӦΪ��http/https/ftp��ͷ��Э��


//����Ϊʶ������ͼƬ����
//ʶ��������������Ľ����޸�
$var = array (
				//����֤��������ͼƬֱ����ͼƬurl�ύʶ��
				//�� http://t.51chuli.com/contact/d827323fa035a7729w060771msa9211z.gif
				'url' =>  'http://t.51chuli.com/contact/d827323fa035a7729w060771msa9211z.gif',
				'language' => 'eng', 
				'service' => 'OcrKingForPhoneNumber', 
				'charset' => 11,
				// ��������������Ϊutf-8  ����Ҫ��gbkҳ�����ʱ Ϊtrue ����������false
				//���߰ѽӿ��ļ����Ϊutf-8
				'gbk'     => true,
);

//ʵ����OcrKingʶ��
$ocrking = new OcrKing(API_KEY);

//�ύʶ��
$ocrking->doOcrKing($var);

//���ʶ��״̬
if (!$ocrking->getStatus()) {
	die ($ocrking->getError());
}

//��ȡʶ����
$result = $ocrking->getResult();

//ԭʼ��� xml��ʽ,һ�����ڳ���ʱ����
//echo $ocrking->getRawResult();


//��ӡʶ��������
//print_r($result);

//����ʾ��Ҫ������
//echo $result['ResultList']['Item']['Result'];
//echo $result['ResultList']['Item']['Status'];
//echo $result['ResultList']['Item']['DesFile'];

echo '����ͼƬʶ��ʼ��';
echo '<br /><br />ʶ��״̬��'.($result['ResultList']['Item']['Status']? '�ɹ�' : 'ʧ��');
if ($result['ResultList']['Item']['Status'] == 'true') {
		echo '<br /><br />ԭʼͼƬ�� <br /><br /><img src="' . $result['ResultList']['Item']['SrcFile'] . '">' ;
		echo '<br /><br />������ͼƬ�ǣ� <br /><br /><img src="' . $result['ResultList']['Item']['DesFile'] . '">' ;
		echo '<br /><br />ʶ��Ľ���ǣ�'.$result['ResultList']['Item']['Result'] ;
}





//����Ϊʶ�𱾵���֤��ͼƬ����
//����֤��ͼƬ��ԭʼ��ַ  https://www.bestpay.com.cn/api/captcha/getCode?1408294248050
//ʶ��������������Ľ����޸�
$var = array (				
				'language' => 'eng', 
				'service' => 'OcrKingForCaptcha', 
				'charset' => 7,
				// ��������������Ϊutf-8  ����Ҫ��gbkҳ�����ʱ Ϊtrue ����������false
				//���߰ѽӿ��ļ����Ϊutf-8
				'gbk'     => true,
				//ʹ���ϴ���ʽʶ����֤��ͼƬʱ 
				//����������봫����֤��ͼƬԭʼurlֵ��type 
				//�Ա����˸���url�����Ż�����ƥ��
				//��demo��typeֵֻ��Դ�demo�е�ͼƬ��������վͼƬ�벻Ҫ�ô�ֵ
				// ���������ԭʼurl��type���Ҵ�һ����ַ��type ����ܿ��ܾ��Ǵ��
                // ������ֹ��̨���κ�Ԥ����  type������Ϊ http://www.nopreprocess.com
                // ���ȷʵ��ȷ����֤��ͼƬ��ԭurl  type������Ϊ http://www.unknown.com  ��ʱ��ֻ̨���г���Ԥ����
				'type'    => 'https://www.bestpay.com.cn/api/captcha/getCode?1408294248050'
);




//������֤��ͼƬ�����أ�ͬʱ�����Ӧ��cookie
$down = getRemoteFile('https://www.bestpay.com.cn/api/captcha/getCode?1408294248050','.png');


//ʵ����OcrKingʶ��
$ocrking = new OcrKing(API_KEY);

//�ϴ�ͼƬʶ�� ����doOcrKing����ǰ����
$ocrking->setFilePath($down['imagepath']);

//�ύʶ��
$ocrking->doOcrKing($var);

//���ʶ��״̬
if (!$ocrking->getStatus()) {
	die ($ocrking->getError());
}

//��ȡʶ����
$result = $ocrking->getResult();

//ԭʼ��� xml��ʽ,һ�����ڳ���ʱ����
//echo $ocrking->getRawResult();


//��ӡʶ��������
//print_r($result);

//����ʾ��Ҫ������
//echo $result['ResultList']['Item']['Result'];
//echo $result['ResultList']['Item']['Status'];
//echo $result['ResultList']['Item']['DesFile'];


echo '<br /><br /><br /><br />����ͼƬʶ��ʼ��<br /><br />';
echo 'ʶ��״̬��'.($result['ResultList']['Item']['Status']? '�ɹ�' : 'ʧ��');
if ($result['ResultList']['Item']['Status'] == 'true') {
		echo '<br /><br />ԭʼͼƬ�� <br /><br /><img src="' . $result['ResultList']['Item']['SrcFile'] . '">' ;
		echo '<br /><br />�����ͼƬ�� <br /><br /><img src="' . $result['ResultList']['Item']['DesFile'] . '">' ;
		echo '<br /><br />ʶ������'.$result['ResultList']['Item']['Result'] ;
		echo '<br /><br /><a href="'.$down['cookieurl'].'" target="_blank">��Ӧcookie</a>' ;
}








/*����Ϊ����ͼƬ�ϴ�ʶ��ʱʹ�÷��������������޸�ɾ��*/
//����ִ�
function random($length, $numeric = 0) {
	PHP_VERSION < '4.2.0' ? mt_srand ( ( double ) microtime () * 1000000 ) : mt_srand ();
	$seed = base_convert ( md5 ( print_r ( $_SERVER, 1 ) . microtime () ), 16, $numeric ? 10 : 35 );
	$seed = $numeric ? (str_replace ( '0', '', $seed ) . '012340567890') : ($seed . 'zZ' . strtoupper ( $seed ));
	$hash = '';
	$max = strlen ( $seed ) - 1;
	for($i = 0; $i < $length; $i ++) {
		$hash .= $seed [mt_rand ( 0, $max )];
	}
	return $hash;
}

//��ȡ����ļ���
function getRandDir() {
	$dir = DOWN_DIR;
	$dir1 = date ( 'Ymd', time () );
	$dir2 = substr ( sprintf ( "%09d", rand ( 0, 128 ) ), 6, 3 );
	$dir3 = substr ( sprintf ( "%09d", rand ( 0, 128 ) ), 6, 3 );
	! is_dir ( $dir ) && mkdir ( $dir , 0777 );
	! is_dir ( $dir . '/' . $dir1 ) && mkdir ( $dir . '/' . $dir1, 0777 );
	! is_dir ( $dir . '/' . $dir1 . '/' . $dir2 ) && mkdir ( $dir . '/' . $dir1 . '/' . $dir2, 0777 );
	! is_dir ( $dir . '/' . $dir1 . '/' . $dir2 . '/' . $dir3 ) && mkdir ( $dir . '/' . $dir1 . '/' . $dir2 . '/' . $dir3, 0777 );
	return $dir . $dir1 . '/' . $dir2 . '/' . $dir3 . '/';
}

//����Զ���ļ� 
function getRemoteFile($url, $fileExt) {
	$result = array ();
	$randName = random ( 32 );
	$fileName = getRandDir () . $randName . $fileExt;
	$cookieFile = getRandDir () . $randName .'.txt';
	$ch = curl_init ( $url );
	$fp = fopen ( $fileName, "wb" );
	curl_setopt ( $ch, CURLOPT_FILE, $fp );
	curl_setopt ( $ch, CURLOPT_HEADER, 0 );
	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, 1 );
	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, 0 );
	curl_setopt ( $ch, CURLOPT_ENCODING, 'gzip,deflate' );
	curl_setopt ( $ch, CURLOPT_COOKIE, '' );
	curl_setopt ( $ch, CURLOPT_COOKIEJAR, $cookieFile);
	curl_setopt ( $ch, CURLOPT_REFERER, getSiteUrl () );
	curl_setopt ( $ch, CURLOPT_USERAGENT, '"Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)' );
	curl_setopt ( $ch, CURLOPT_TIMEOUT, 60 );
	curl_exec ( $ch );
	curl_close ( $ch );
	fclose ( $fp );
	$result ['imageurl'] = str_ireplace ( S_ROOT, getSiteUrl (), $fileName );
	$result ['imagepath'] = $fileName;
	$result ['cookieurl'] = str_ireplace ( S_ROOT, getSiteUrl (), $cookieFile );
	return $result;
}

//
function sWriteFile ($fileName, $writetext, $utf8 = false, $openmod = 'w')
{
    if (@$fp = fopen($fileName, $openmod)) {
        flock($fp, 2);
        if ($utf8) {
            fwrite($fp, chr(0xEF) . chr(0xBB) . chr(0xBF) . $writetext);
        } else {
            fwrite($fp, $writetext);
        }
        fclose($fp);
        return true;
    } else {
        return false;
    }
}

function sHtmlSpecialChars($string) {
		if (is_array($string)) {
			foreach ($string as $key => $val) {
				$string [$key] = shtmlspecialchars($val);
			}
		} else {
			$string = preg_replace('/&amp;((#(\d{3,5}|x[a-fA-F0-9]{4})|[a-zA-Z][a-z0-9]{2,5});)/', '&\\1', str_replace(array ('&', '"', '<', '>'), array ('&amp;', '&quot;', '&lt;', '&gt;'), $string));
		}
		return $string;
	}

function getSiteUrl($all = false) {
		$uri = $_SERVER ['PHP_SELF'] ? $_SERVER ['PHP_SELF'] : $_SERVER ['SCRIPT_NAME'];
		if ($all) {
			return sHtmlSpecialChars('http://' . $_SERVER ['HTTP_HOST'] . substr($uri, 0, strrpos($uri, '/')) . $uri);
		}
		return sHtmlSpecialChars('http://' . $_SERVER ['HTTP_HOST'] . substr($uri, 0, strrpos($uri, '/') + 1));
	}