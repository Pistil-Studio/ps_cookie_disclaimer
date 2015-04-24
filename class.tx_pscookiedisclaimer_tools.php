<?php


class tx_pscookiedisclaimer_tools extends tslib_pibase {

	var $scriptRelPath = 'class.tx_pscookiedisclaimer_tools.php';
	var $prefixId      = 'tx_pscookiedisclaimer_tools';		
	var $extKey        = 'ps_cookie_disclaimer';
	var $pi_checkCHash = true;


	/**
	 * 
	 * 
	 * @param 
	 * @access public
	 * @return void 
	 */
	function tx_pscookiedisclaimer_tools() {
		$this->tslib_pibase();		
		$this->pi_setPiVarDefaults();
		$this->pi_loadLL();
	}



	/**
	 * [renderCookieDisclaimer description]
	 * @param  [type] $c    [description]
	 * @param  [type] $conf [description]
	 * @return [type]       [description]
	 */
	function renderCookieDisclaimer($c, $conf){

		// get extension manager configuration
		$this->lConf = unserialize($GLOBALS['TYPO3_CONF_VARS']['EXT']['extConf']['ps_cookie_disclaimer']);

		if(empty($this->lConf['display'])){
			return false;
		}



		$GLOBALS['TSFE']->additionalHeaderData[$this->extKey.'-css'] = '<link rel="stylesheet" type="text/css" href="' . t3lib_extMgm::siteRelPath($this->extKey) . 'res/cookie.css" />';

		$acceptLink = $this->cObj->TYPOLINK('', array(
			'returnLast' => 'url',
			'parameter' => $GLOBALS['TSFE']->id,
			'useCacheHash' => 1,
			'additionalParams' => '&tx_pscookiedisclaimer_tools[acceptCookie]=1'
		));

		if(!empty($this->piVars['acceptCookie'])){
			setcookie("acceptCookie", '1', time()+(3600*24*31*12), '/');
			return;
		}


		if(!empty($_COOKIE["acceptCookie"])){
			return;
		} else {
			$html = '<div id="psCookieDisclaimer">'.$this->pi_getLL('disclaimer');	

			if(!empty($this->lConf['detailPageId'])){
				$myLink = $this->cObj->typolink('',array(
					'parameter' => $this->lConf['detailPageId'],
					'returnLast' => 'url'
				));
				$html.= '<br /><a href="'.$myLink.'" class="moreInfo">'.$this->pi_getLL('link').'</a>';
			}

			$html.= ' <a rel="nofollow" href="'.$acceptLink.'" class="closeLink">'.$this->pi_getLL('accept').'</a>';
			$html.= '</div>';
			return $html;
		}

		

	}

}



if (defined('TYPO3_MODE') && $TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ps_cookie_disclaimer/class.tx_pscookiedisclaimer_tools.php'])    {
    include_once($TYPO3_CONF_VARS[TYPO3_MODE]['XCLASS']['ext/ps_cookie_disclaimer/class.tx_pscookiedisclaimer_tools.php']);
}

?>
