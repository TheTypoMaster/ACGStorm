<?php
class VideoUrlParser {
	static public $timeout = 5;
	const USER_AGENT = "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US) AppleWebKit/534.10 (KHTML, like Gecko)
        Chrome/8.0.552.224 Safari/534.10";
	const CHECK_URL_VALID = "/(qiyi\.com|youtube\.com|youku\.com|tudou\.com|ku6\.com|56\.com|letv\.com|(video|ent)\.sina\.com\.cn|(my\.)?tv\.sohu\.com|v\.qq\.com)/";
	static public function parse($url = '', $createObject = true) {
		$lowerurl = strtolower ( $url );
		preg_match ( self::CHECK_URL_VALID, $lowerurl, $matches );
		if (! $matches)
			return false;
		switch ($matches [1]) {
			case 'youtube.com' :
				$data = self::_parseYouTuBe ( $url );
				break;
			case 'qiyi.com' :
				$data = self::_parseQiyi ( $url );
				break;
			case 'youku.com' :
				$data = self::_parseYouku ( $url );
				break;
			case 'tudou.com' :
				$data = self::_parseTudou ( $url );
				break;
			case 'ku6.com' :
				$data = self::_parseKu6 ( $url );
				break;
			case '56.com' :
				$data = self::_parse56 ( $url );
				break;
			case 'letv.com' :
				$data = self::_parseLetv ( $url );
				break;
			case 'ent.sina.com.cn' :
			case 'video.sina.com.cn' :
				$data = self::_parseSina ( $url );
				break;
			case 'my.tv.sohu.com' :
			case 'tv.sohu.com' :
			case 'sohu.com' :
				$data = self::_parseSohu ( $url );
				break;
			case 'v.qq.com' :
				$data = self::_parseQq ( $url );
				break;
			default :
				$data = false;
		}
		if ($data && $createObject)
			$data ['object'] = "<embed src=\"{$data['swf']}\" quality=\"high\" width=\"480\" height=\"400\" align=\"middle\" allowNetworking=\"all\" allowScriptAccess=\"always\" type=\"application/x-shockwave-flash\"></embed>";
		return $data;
	}
	
	//youtube
	static private function _parseYouTuBe($url, $rel = 0) {
		$urls = parse_url ( $url );
		if ($urls ['host'] == 'youtu.be')
			$id = ltrim ( $urls ['path'], '/' );
		else if (strpos ( $urls ['path'], 'embed' ) == 1)
			$id = end ( explode ( '/', $urls ['path'] ) );
		else if (strpos ( $url, '/' ) === false)
			$id = $url;
		else {
			parse_str ( $urls ['query'] );
			$id = $v;
		}
		$data ['img'] = 'http://i1.ytimg.com/vi/' . $id . '/hqdefault.jpg';
		$data ['url'] = $url;
		
		/* $video_id = 'BGCqmjxQGOE';
		$content = file_get_contents("http://youtube.com/get_video_info?video_id=" . $video_id);
		parse_str($content, $ytarr);
		echo $ytarr['title']; */
		
		$data ['title'] = $id;
		$data ['swf'] = '<iframe width="640" height="480" src="http://www.youtube.com/embed/'.$id.'" frameborder="0" allowfullscreen></iframe>';
		return $data;
	}
	

	static private function _parseQiyi($link) {
		$content = file_get_contents($link);
		//file_put_contents('./log', $content."\r\n",FILE_APPEND);
		preg_match_all("/title[\w\W]:[\w\W]\"(.*?)\",/i",$content,$str2);
		preg_match_all("/videoId[\w\W]:[\w\W]\"(.*?)\",/i",$content,$str3);
		preg_match_all("/albumId[\w\W]:[\w\W]\"(.*?)\",/i",$content,$str4);
		preg_match_all("/tvId[\w\W]:[\w\W]\"(.*?)\",/i",$content,$str5);
		$title = $str2[1][0];    //得到視頻標題
		//url : "http://www.qiyi.com/yinyue/20110712/4708a7bb0dbf0c0b.html",
		preg_match_all("/url[\w\W]:[\w\W]\"http:\/\/www.qiyi.com\/yinyue\/([\w\-]+)\/?/i",$content,$str);
	
		$vdate = $str[1][0]; //得到日期
		$vcode = $str3[1][0];
		$albid = $str4[1][0];  //所在專輯ID
		$vinid = $str5[1][0]; //視頻ID
	
		//生成圖片和視頻URL
		$img[1][0] = "http://www.qiyipic.com/thumb/".$vdate."/a".$albid."_160_90.jpg";
		$geturl = "http://player.video.qiyi.com/".$vcode;
		$str['img'] = $img[1][0];
		$str['title'] = $title;
		$str['url'] = $geturl;
		$str['swf'] = $message;
		return  $str;
	}
	
	/**
	 * 腾讯视频
	 * http://v.qq.com/cover/o/o9tab7nuu0q3esh.html?vid=97abu74o4w3
	 * http://v.qq.com/play/97abu74o4w3.html
	 * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o.html
	 * http://v.qq.com/cover/d/dtdqyd8g7xvoj0o/9SfqULsrtSb.html
	 * http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?_v=20110829&vid=97abu74o4w3&autoplay=1&list=2&showcfg=1&tpid=23&title=%E7%AC%AC%E4%B8%80%E7%8E%B0%E5%9C%BA&adplay=1&cid=o9tab7nuu0q3esh
	 */
	static private function _parseQq($url) {
		if (preg_match ( "/\/play\//", $url )) {
			$html = self::_fget ( $url );
			preg_match ( "/url=[^\"]+/", $html, $matches );
			if (! $matches)
				return false;
			$url = $matches [0];
		}
		preg_match ( "/vid=([^\_]+)/", $url, $matches );
		$vid = $matches [1];
		$html = self::_fget ( $url );
		// query
		preg_match ( "/flashvars\s=\s\"([^;]+)/s", $html, $matches );
		$query = $matches [1];
		if (! $vid) {
			preg_match ( "/vid\s?=\s?vid\s?\|\|\s?\"(\w+)\";/i", $html, $matches );
			$vid = $matches [1];
		}
		$query = str_replace ( '"+vid+"', $vid, $query );
		parse_str ( $query, $output );
		$data ['img'] = "http://vpic.video.qq.com/{$output['cid']}/{$vid}_1.jpg";
		$data ['url'] = $url;
		$data ['title'] = $output ['title'];
		$data ['swf'] = "http://imgcache.qq.com/tencentvideo_v1/player/TencentPlayer.swf?" . $query;
		return $data;
	}
	
	/**
	 * 优酷网
	 * http://v.youku.com/v_show/id_XMjI4MDM4NDc2.html
	 * http://player.youku.com/player.php/sid/XMjU0NjI2Njg4/v.swf
	 */
	static private function _parseYouku($url) {
		preg_match ( "#https?://v.youku.com/v_show/id_(?<video_id>[a-z0-9_=-]+)#i", $url, $matches );
		$cnt = count ( $matches );
		if ($cnt > 0) {
			$link = "http://v.youku.com/player/getPlayList/VideoIDS/{$matches['video_id']}/timezone/+08/version/5/source/out?password=&ran=2513&n=3";
		} else {
			return false;
		}
		// 这一段是用来解析json数据，如果想跨域用js来取，这个表示压力好大
		$ch = @curl_init ( $link );
		@curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		$cexecute = @curl_exec ( $ch );
		@curl_close ( $ch );
		if ($cexecute) {
			$result = json_decode ( $cexecute, true );
			$json = $result ['data'] [0];
			
			
			$data ['vid'] = $json['vidEncoded'];
			$data ['img'] = $json ['logo']; // 视频缩略图
			$data ['imgSmall'] = str_replace( '.com/11', '.com/01', $json['logo'] ); // 视频小图
			$data ['title'] = $json ['title']; // 标题啦
			$data ['time'] = $json['seconds'];
			$data ['url'] = $url;
			$data ['swf'] = "http://player.youku.com/player.php/sid/{$matches['video_id']}/v.swf"; // 视频地址
			$data ['tag'] = $json['tags'];

			
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * 土豆网
	 * http://www.tudou.com/programs/view/Wtt3FjiDxEE/
	 * http://www.tudou.com/v/Wtt3FjiDxEE/v.swf
	 *
	 * http://www.tudou.com/playlist/p/a65718.html?iid=74909603
	 * http://www.tudou.com/l/G5BzgI4lAb8/&iid=74909603/v.swf
	 */
	static private function _parseTudou($url) {
		preg_match ( "#https?://(?:www\.)?tudou\.com/(?:programs/view|listplay|albumplay/(?<list_id>[a-z0-9_=\-]+))/(?<video_id>[a-z0-9_=\-]+)#i", $url, $matches );
		$cnt = count ( $matches );
		if ($cnt > 0) {
			$link = 'http://api.tudou.com/v3/gw?method=item.info.get&appKey=myKey&format=json&itemCodes=' . $matches ["video_id"];
		} else {
			return false;
		}
		$ch = @curl_init ( $link );
		@curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
		@$cexecute = @curl_exec ( $ch );
		@curl_close ( $ch );
		if ($cexecute) {
			$result = json_decode ( @$cexecute, true );
			$json = $result ['multiResult'] ['results'] [0];
			

			$data ['img'] = $json ['bigPicUrl'];
			$data ['title'] = $json ['title'];
			$data ['url'] = $json ['itemUrl'];
			$data ['swf'] = $json ['outerPlayerUrl'];
			
			
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * 酷6网
	 * http://v.ku6.com/film/show_520/3X93vo4tIS7uotHg.html
	 * http://v.ku6.com/special/show_4926690/Klze2mhMeSK6g05X.html
	 * http://v.ku6.com/show/7US-kDXjyKyIInDevhpwHg...html
	 * http://player.ku6.com/refer/3X93vo4tIS7uotHg/v.swf
	 */
	static private function _parseKu6($vid) {
		if ( !$vid ) {
			return false;
		}
		if ( !preg_match( '/^[0-9a-z_-]+\.{0,2}$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/v\.ku6\.com\/show\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/player\.ku6\.com\/refer\/([0-9a-z_-]+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/v\.ku6\.com\/special\/show_\d+\/([0-9a-z_-]+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		$vid = preg_replace( '/^([0-9a-z_-]+)\.*$/i', '$1..', $vid );
		if ( !$json = self::url( 'http://v.ku6.com/fetchVideo4Player/'. $vid .'.html' ) ) {
			return false;
		}
		if ( !$json = @json_decode( $json, true ) ) {
			return false;
		}
		if ( empty( $json['data']['picpath'] ) ) {
			return false;
		}
		
		$json = $json['data'];
		$json['vtime'] = explode( ',', $json['vtime'] );
		$r['vid'] = $vid;
		$r['url'] = 'http://v.ku6.com/show/'. $vid .'.html?ref=http://www.lianyue.org/';
		$r['swf'] = 'http://player.ku6.com/refer/'. $vid .'/v.swf';
		$r['title'] = $json['t'];
		$r['img'] = $json['bigpicpath'];
		$r['imgSmall'] = $json['picpath'];
		$r['time'] = reset( $json['vtime'] );
		$r['tag'] = empty( $json['tag'] ) ? array() : self::array_unempty( explode( ' ', $json['tag'] ) );
		return $r;
	}
	
	/**
	 * 56网
	 * http://www.56.com/u73/v_NTkzMDcwNDY.html
	 * http://player.56.com/v_NTkzMDcwNDY.swf
	 */
	static private function _parse56($url) {
		preg_match ( "#https?://(?:www\.)?56\.com/[a-z0-9]+/(?:play_album\-aid\-[0-9]+_vid\-(?<video_id1>[a-z0-9_=\-]+)|v_(?<video_id2>[a-z0-9_=\-]+))#i", $url, $matches );
		$cnt = count ( $matches );
		if ($cnt > 0) {
			$cid = $matches ["video_id1"] != "" ? $matches ["video_id1"] : $matches ["video_id2"];
		} else {
			return false;
		}
		include ("56sdk.php");
		$c = new open56Client ( APPKEY, APPSECRET );
		$cexecute = $c->getVideoInfoApp ( $cid );
		if ($cexecute) {
			$result = json_decode ( $cexecute, true );
			$json = $result [0];
			$data ['img'] = $json ['img'];
			$data ['title'] = $json ['title'];
			$data ['url'] = $json ['vid'];
			$data ['swf'] = $json ['swf'];
			return $data;
		} else {
			return false;
		}
	}
	
	/**
	 * 乐视网
	 * http://www.letv.com/ptv/vplay/1168109.html
	 * http://www.letv.com/player/x1168109.swf
	 */
	static private function _parseLetv($vid) {
		if ( !$vid ) {
			return false;
		}
		
		if ( !preg_match( '/^[0-9]+$/i', $vid ) ) {
			if ( !preg_match( '/^http\:\/\/www\.letv\.com\/ptv\/vplay\/(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/i\d+\.imgs\.letv\.com\/player\/swfPlayer\.swf\?[0-9a-z&=_-]*id=(\d+)/i', $vid, $match ) && !preg_match( '/^http\:\/\/www\.letv\.com\/player\/x(\d+)/i', $vid, $match ) ) {
				return false;
			}
			$vid = $match[1];
		}
		if ( !$html = self::url( 'http://www.letv.com/ptv/vplay/'. $vid .'.html' ) ) {
			return false;
		}
		if ( !preg_match( '/\<script.*?__INFO__\s*\\=\{(.+?)\<\/script\>/is', $html, $match ) ) {
			return false;
		}
		
		$html = $match[1];
		preg_match('/vid:(\d+)/is', $html ,$match );
		$r['vid'] = $match[1];
		preg_match('/title:\"([^\"]+)\"/is', $html ,$match );
		$r['title'] = $match[1];
		$r['url'] = 'http://www.letv.com/ptv/vplay/' . $r['vid'] . '.html';
		$r['swf'] = 'http://i7.imgs.letv.com/player/swfPlayer.swf?id='. $r['vid'];
		$r['img'] = preg_replace( '/^.+pic\s*\:\s*["\'](http.+?)["\']\s*,.+$/is', '$1', $html );
		$r['imgSmall'] = preg_replace( '/^.+pic\s*\:\s*["\'](http.+?)["\']\s*,.+$/is', '$1', $html );
		$r['time'] = 0;
		$r['tag'] = array();
		return $r;
	}
	
	// 搜狐TV http://my.tv.sohu.com/u/vw/5101536
	static private function _parseSohu($url) {
		$html = self::_fget ( $url );
		$html = iconv ( "GBK", "UTF-8", $html );
		preg_match_all ( "/og:(?:title|image|videosrc)\"\scontent=\"([^\"]+)\"/s", $html, $matches );
		$data ['swf'] = $matches [1] [0];
		$data ['title'] = $matches [1] [1];
		$data ['img'] = $matches [1] [2];
		$data ['url'] = $url;
		return $data;
	}
	
	/*
	 * 新浪播客 http://video.sina.com.cn/v/b/48717043-1290055681.html http://you.video.sina.com.cn/api/sinawebApi/outplayrefer.php/vid=48717043_1290055681_PUzkSndrDzXK+l1lHz2stqkP7KQNt6nki2O0u1ehIwZYQ0/XM5GdatoG5ynSA9kEqDhAQJA4dPkm0x4/s.swf
	 */
	static private function _parseSina($url) {		
		preg_match("/(\d+)(?:\-|\_)(\d+)/", $url, $matches);
	    $url = "http://video.sina.com.cn/v/b/{$matches[1]}-{$matches[2]}.html";
	    $html = self::_fget($url);
	    preg_match("/video\s?:\s?([^<]+)}/", $html, $matches);
	    $find = array("/\n/", "/\s*/", "/\'/", "/\{([^:,]+):/", "/,([^:]+):/", "/:[^\d\"]\w+[^\,]*,/i");
	    $replace = array('', '', '"', '{"\\1":', ',"\\1":', ':"",');
	    $str = preg_replace($find, $replace, $matches[1]);
	    $arr = json_decode($str, true);
	    $data['img'] = $arr['pic'];
	    $data['title'] = $arr['title'];
	    $data['url'] = $url;
	    $data['swf'] = $arr['swfOutsideUrl'];
	    return $data;
	}
	
	/*
	 * 通过 file_get_contents 获取内容
	 */
	static private function _fget($url = '') {
		if (! $url)
			return false;
		$html = file_get_contents ( $url );
		// 判断是否gzip压缩
		if ($dehtml = self::_gzdecode ( $html ))
			return $dehtml;
		else
			return $html;
	}
	
	/*
	 * 通过 fsockopen 获取内容
	 */
	static private function _fsget($path = '/', $host = '', $user_agent = '') {
		if (! $path || ! $host)
			return false;
		$user_agent = $user_agent ? $user_agent : self::USER_AGENT;
		
		$out = <<<HEADER
GET $path HTTP/1.1
Host: $host
User-Agent: $user_agent
Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8
Accept-Language: zh-cn,zh;q=0.5
Accept-Charset: GB2312,utf-8;q=0.7,*;q=0.7\r\n\r\n
HEADER;
		$fp = @fsockopen ( $host, 80, $errno, $errstr, 10 );
		if (! $fp)
			return false;
		if (! fputs ( $fp, $out ))
			return false;
		while ( ! feof ( $fp ) ) {
			$html .= fgets ( $fp, 1024 );
		}
		fclose ( $fp );
		// 判断是否gzip压缩
		if ($dehtml = self::_gzdecode ( $html ))
			return $dehtml;
		else
			return $html;
	}
	
	/*
	 * 通过 curl 获取内容
	 */
	static private function _cget($url = '', $user_agent = '') {
		if (! $url)
			return;
		
		$user_agent = $user_agent ? $user_agent : self::USER_AGENT;
		
		$ch = curl_init ();
		curl_setopt ( $ch, CURLOPT_URL, $url );
		curl_setopt ( $ch, CURLOPT_HEADER, 0 );
		if (strlen ( $user_agent ))
			curl_setopt ( $ch, CURLOPT_USERAGENT, $user_agent );
		
		ob_start ();
		curl_exec ( $ch );
		$html = ob_get_contents ();
		ob_end_clean ();
		
		if (curl_errno ( $ch )) {
			curl_close ( $ch );
			return false;
		}
		curl_close ( $ch );
		if (! is_string ( $html ) || ! strlen ( $html )) {
			return false;
		}
		return $html;
		// 判断是否gzip压缩
		if ($dehtml = self::_gzdecode ( $html ))
			return $dehtml;
		else
			return $html;
	}
	static private function _gzdecode($data) {
		$len = strlen ( $data );
		if ($len < 18 || strcmp ( substr ( $data, 0, 2 ), "\x1f\x8b" )) {
                    
			return null; // Not GZIP format (See RFC 1952)
		}
                
		$method = ord ( substr ( $data, 2, 1 ) ); // Compression method
		$flags = ord ( substr ( $data, 3, 1 ) ); // Flags
		if ($flags & 31 != $flags) {
			// Reserved bits are set -- NOT ALLOWED by RFC 1952
			return null;
		}
		// NOTE: $mtime may be negative (PHP integer limitations)
                
		$mtime = unpack ( "V", substr ( $data, 4, 4 ) );
		$mtime = $mtime [1];
		$xfl = substr ( $data, 8, 1 );
		$os = substr ( $data, 8, 1 );
		$headerlen = 10;
		$extralen = 0;
		$extra = "";
		if ($flags & 4) {
			// 2-byte length prefixed EXTRA data in header
			if ($len - $headerlen - 2 < 8) {
				return false; // Invalid format
			}
			$extralen = unpack ( "v", substr ( $data, 8, 2 ) );
			$extralen = $extralen [1];
			if ($len - $headerlen - 2 - $extralen < 8) {
				return false; // Invalid format
			}
			$extra = substr ( $data, 10, $extralen );
			$headerlen += 2 + $extralen;
		}
		
		$filenamelen = 0;
		$filename = "";
		if ($flags & 8) {
			// C-style string file NAME data in header
			if ($len - $headerlen - 1 < 8) {
				return false; // Invalid format
			}
			$filenamelen = strpos ( substr ( $data, 8 + $extralen ), chr ( 0 ) );
			if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
				return false; // Invalid format
			}
			$filename = substr ( $data, $headerlen, $filenamelen );
			$headerlen += $filenamelen + 1;
		}
		
		$commentlen = 0;
		$comment = "";
		if ($flags & 16) {
			// C-style string COMMENT data in header
			if ($len - $headerlen - 1 < 8) {
				return false; // Invalid format
			}
			$commentlen = strpos ( substr ( $data, 8 + $extralen + $filenamelen ), chr ( 0 ) );
			if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
				return false; // Invalid header format
			}
			$comment = substr ( $data, $headerlen, $commentlen );
			$headerlen += $commentlen + 1;
		}
		
		$headercrc = "";
		if ($flags & 1) {
			// 2-bytes (lowest order) of CRC32 on header present
			if ($len - $headerlen - 2 < 8) {
				return false; // Invalid format
			}
			$calccrc = crc32 ( substr ( $data, 0, $headerlen ) ) & 0xffff;
			$headercrc = unpack ( "v", substr ( $data, $headerlen, 2 ) );
			$headercrc = $headercrc [1];
			if ($headercrc != $calccrc) {
				return false; // Bad header CRC
			}
			$headerlen += 2;
		}
		
		// GZIP FOOTER - These be negative due to PHP's limitations
                
		$datacrc = unpack ( "V", substr ( $data, - 8, 4 ) );
		$datacrc = $datacrc [1];
		$isize = unpack ( "V", substr ( $data, - 4 ) );
		$isize = $isize [1];
		
		// Perform the decompression:
		$bodylen = $len - $headerlen - 8;
		if ($bodylen < 1) {
			// This should never happen - IMPLEMENTATION BUG!
			return null;
		}
		$body = substr ( $data, $headerlen, $bodylen );
		$data = "";
		if ($bodylen > 0) {
			switch ($method) {
				case 8 :
					// Currently the only supported compression method:
					$data = gzinflate ( $body );
					break;
				default :
					// Unknown compression method
					return false;
			}
		} else {
			// ...
		}
		
		if ($isize != strlen ( $data ) || crc32 ( $data ) != $datacrc) {
			// Bad format! Length or CRC doesn't match!
			return false;
		}
		return $data;
	}
	
	/**
	 *	打开 url
	 *
	 *	1 参数 url 地址
	 *	2 参数 header 引用
	 *
	 *	返回值 字符串
	 **/
	static private function url( $url = '',  &$header = array() ) {
		$timeout = self::$timeout;
		$accept = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1478.0 Safari/537.36';
	
		$content = '';
	
	
		if ( function_exists( 'curl_init' ) ) {
			// curl 的
			$curl = curl_init( $url );
			curl_setopt( $curl, CURLOPT_DNS_CACHE_TIMEOUT, 86400 ) ;
			curl_setopt( $curl, CURLOPT_DNS_USE_GLOBAL_CACHE, true ) ;
			curl_setopt( $curl, CURLOPT_BINARYTRANSFER, true );
			curl_setopt( $curl, CURLOPT_ENCODING, 'gzip,deflate' );
			curl_setopt( $curl, CURLOPT_HEADER, true );
			curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
			curl_setopt( $curl, CURLOPT_USERAGENT, $accept );
			curl_setopt( $curl, CURLOPT_TIMEOUT, $timeout );
			$content = curl_exec ( $curl );
			curl_close( $curl );
	
		} elseif ( function_exists( 'file_get_contents' ) ) {
				
			// file_get_contents
			$head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
			$head[] = "User-Agent: $accept";
			$head[] = "Accept-Language: zh-CN,zh;q=0.5";
			$head = implode( "\r\n", $head ). "\r\n\r\n";
				
			$context['http'] = array (
					'method' => "GET" ,
					'header' => $head,
					'timeout' => $timeout,
			);
                        
			$content = @file_get_contents( $url, false , stream_context_create( $context ) );
			if ( $gzip = self::gzip( $content ) ) {
				$content = $gzip;
			}
                        
			$content = implode( "\r\n", $http_response_header ). "\r\n\r\n" . $content;
				
		} elseif ( function_exists('fsockopen') || function_exists('pfsockopen') ) {
			// fsockopen or pfsockopen
			$url = parse_url( $url );
			if ( empty( $url['host'] ) ) {
				return false;
			}
			$url['port'] = empty( $url['port'] ) ? 80 : $url['port'];
				
			$host = $url['host'];
			$host .= $url['port'] == 80 ? '' : ':'. $port;
				
			$get = '';
			$get .= empty( $url['path'] ) ? '/' : $url['path'];
			$get .= empty( $url['query'] ) ? '' : '?'. $url['query'];
				
				
			$head[] = "GET $get HTTP/1.1";
			$head[] = "Host: $host";
			$head[] = "Accept: text/html,application/xhtml+xml,application/xml;q=0.9,*/*;q=0.8";
			$head[] = "User-Agent: $accept";
			$head[] = "Accept-Language: zh-CN,zh;q=0.5";
			$head[] = "Connection: Close";
			$head = implode( "\r\n", $head ). "\r\n\r\n";
	
			$function = function_exists('fsockopen') ? 'fsockopen' : 'pfsockopen';
			if ( !$fp = @$function( $url['host'], $url['port'], $errno, $errstr, $timeout ) ) {
				return false;
			}
				
			if( !fputs( $fp, $head ) ) {
				return false;
			}
				
			while ( !feof( $fp ) ) {
				$content .= fgets( $fp, 1024 );
			}
			fclose( $fp );
				
			if ( $gzip = $this->gzip( $content ) ) {
				$content = $gzip;
			}
				
			$content = str_replace( "\r\n", "\n", $content );
			$content = explode( "\n\n", $content, 2 );
				
			if ( !empty( $content[1] ) && !strpos( $content[0], "\nContent-Length:" ) ) {
				$content[1] = preg_replace( '/^[0-9a-z\r\n]*(.+?)[0-9\r\n]*$/i', '$1', $content[1] );
			}
			$content = implode( "\n\n", $content );
		}
	
		// 分割 header  body
		$content = str_replace( "\r\n", "\n", $content );
		$content = explode( "\n\n", $content, 2 );
	
		// 解析 header
		$header = array();
		foreach ( explode( "\n", $content[0] ) as $k => $v ) {
			if ( $v ) {
				$v = explode( ':', $v, 2 );
				if( isset( $v[1] ) ) {
					if ( substr( $v[1],0 , 1 ) == ' ' ) {
						$v[1] = substr( $v[1], 1 );
					}
					$header[trim($v[0])] = $v[1];
				} elseif ( empty( $r['status'] ) && preg_match( '/^(HTTP|GET|POST)/', $v[0] ) ) {
					$header['status'] = $v[0];
				} else {
					$header[] = $v[0];
				}
			}
		}
	
	
		$body = empty( $content[1] ) ? '' : $content[1];
		return $body;
	}
	
	/**
	 *	gzip 解压缩
	 *
	 *	1 参数 data
	 *
	 *	返回值 false or string
	 **/
	static private function gzip( $data ) {
		$len = strlen ( $data );
		if ($len < 18 || strcmp ( substr ( $data, 0, 2 ), "\x1f\x8b" )) {
			//return null; // Not GZIP format (See RFC 1952)
		}
		$method = ord ( substr ( $data, 2, 1 ) ); // Compression method
		$flags = ord ( substr ( $data, 3, 1 ) ); // Flags
		if ($flags & 31 != $flags) {
			// Reserved bits are set -- NOT ALLOWED by RFC 1952
			return null;
		}
		// NOTE: $mtime may be negative (PHP integer limitations)
		$mtime = unpack ( "V", substr ( $data, 4, 4 ) );
		$mtime = $mtime [1];
		$xfl = substr ( $data, 8, 1 );
		$os = substr ( $data, 8, 1 );
		$headerlen = 10;
		$extralen = 0;
		$extra = "";
		if ($flags & 4) {
			// 2-byte length prefixed EXTRA data in header
			if ($len - $headerlen - 2 < 8) {
				return false; // Invalid format
			}
			$extralen = unpack ( "v", substr ( $data, 8, 2 ) );
			$extralen = $extralen [1];
			if ($len - $headerlen - 2 - $extralen < 8) {
				return false; // Invalid format
			}
			$extra = substr ( $data, 10, $extralen );
			$headerlen += 2 + $extralen;
		}
		 
		$filenamelen = 0;
		$filename = "";
		if ($flags & 8) {
			// C-style string file NAME data in header
			if ($len - $headerlen - 1 < 8) {
				return false; // Invalid format
			}
			$filenamelen = strpos ( substr ( $data, 8 + $extralen ), chr ( 0 ) );
			if ($filenamelen === false || $len - $headerlen - $filenamelen - 1 < 8) {
				return false; // Invalid format
			}
			$filename = substr ( $data, $headerlen, $filenamelen );
			$headerlen += $filenamelen + 1;
		}
		 
		$commentlen = 0;
		$comment = "";
		if ($flags & 16) {
			// C-style string COMMENT data in header
			if ($len - $headerlen - 1 < 8) {
				return false; // Invalid format
			}
			$commentlen = strpos ( substr ( $data, 8 + $extralen + $filenamelen ), chr ( 0 ) );
			if ($commentlen === false || $len - $headerlen - $commentlen - 1 < 8) {
				return false; // Invalid header format
			}
			$comment = substr ( $data, $headerlen, $commentlen );
			$headerlen += $commentlen + 1;
		}
		 
		$headercrc = "";
		if ($flags & 1) {
			// 2-bytes (lowest order) of CRC32 on header present
			if ($len - $headerlen - 2 < 8) {
				return false; // Invalid format
			}
			$calccrc = crc32 ( substr ( $data, 0, $headerlen ) ) & 0xffff;
			$headercrc = unpack ( "v", substr ( $data, $headerlen, 2 ) );
			$headercrc = $headercrc [1];
			if ($headercrc != $calccrc) {
				return false; // Bad header CRC
			}
			$headerlen += 2;
		}
		 
		// GZIP FOOTER - These be negative due to PHP's limitations
		$datacrc = unpack ( "V", substr ( $data, - 8, 4 ) );
		$datacrc = $datacrc [1];
		$isize = unpack ( "V", substr ( $data, - 4 ) );
		$isize = $isize [1];
		 
		// Perform the decompression:
		$bodylen = $len - $headerlen - 8;
		if ($bodylen < 1) {
			// This should never happen - IMPLEMENTATION BUG!
			return null;
		}
		$body = substr ( $data, $headerlen, $bodylen );
		$data = "";
		if ($bodylen > 0) {
			switch ($method) {
				case 8 :
					// Currently the only supported compression method:
					$data = gzinflate ( $body );
					break;
				default :
					// Unknown compression method
					return false;
			}
		} else {
			//...
		}
		 
		if ($isize != strlen ( $data ) || crc32 ( $data ) != $datacrc) {
			// Bad format!  Length or CRC doesn't match!
			return false;
		}
		return $data;
	}
	
	/**
	 *	删除 数组中 的空值
	 *
	 *	1 参数 数组
	 *	2 参数 是否回调删除多维数组
	 *
	 *	返回值 数组
	 **/
	static private function array_unempty( $a = array(), $call = false ) {
	
		foreach ( $a as $k => $v ) {
			if ( $call && is_array( $a ) && $a ) {
				$a[$k] = $this->array_unempty( $a, $call );
			}
			if ( empty( $v ) ) {
				unset( $a[$k] );
			}
		}
		return $a;
	}
}
