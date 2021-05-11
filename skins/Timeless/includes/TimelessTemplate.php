<?php
/**
 * BaseTemplate class for the Timeless skin
 *
 * @ingroup Skins
 */

class TimelessTemplate extends BaseTemplate {

	/** @var array */
	protected $pileOfTools;

	/** @var array */
	protected $sidebar;

	/** @var array|null */
	protected $collectionPortlet;
	

	/**
	 * Outputs the entire contents of the page
	 */
	public function execute() {
		$this->sidebar = $this->getSidebar();

		// Collection sidebar thing
		if ( isset( $this->sidebar['coll-print_export'] ) ) {
			$this->collectionPortlet = $this->sidebar['coll-print_export'];
			unset( $this->sidebar['coll-print_export'] );
		}

		$this->pileOfTools = $this->getPageTools();
		$userLinks = $this->getUserLinks();

		// Open html, body elements, etc
		$html = $this->get( 'headelement' );

		$html .= Html::openElement( 'div', [ 'id' => 'mw-wrapper', 'class' => $userLinks['class'] ] );

		$html .= Html::rawElement( 'div', [ 'id' => 'mw-header-container', 'class' => 'ts-container' ],
			$this->getHeaderUpper() .
			$this->getHeaderUpperMobile() .
			$this->getHeaderLower()
		);

		// For mobile
		$html .= Html::element( 'div', [ 'id' => 'menus-cover' ] );

		$html .= Html::rawElement( 'div', [ 'id' => 'mw-content-container', 'class' => 'ts-container' ],
			Html::rawElement( 'div', [ 'id' => 'mw-content-block'],
				Html::rawElement( 'div', [ 'id' => 'mw-parser-output' ],
					$this->getContentBlock() .
					$this->getAfterContent()
				) .
				Html::rawElement( 'div', [ 'id' => 'mw-site-navigation' ],
					$this->getMainNavigation() .
					$this->getPageToolSidebar() .
					$this->getCategories()
				) .
				$this->getClear()
			)
		);
		$validFooterLinks = $this->getFooterLinks('flat');
		$footer = '';
		foreach ( $validFooterLinks as $aLink ) {
			$footer .= Html::rawElement(
				'div',
				[ 'id' => Sanitizer::escapeIdForAttribute( $aLink ) ],
				$this->get( $aLink )
			);
		}

		$html .= Html::rawElement( 'div', [ 'id' => 'mw-footer' ], $footer);

		$html .= Html::closeElement( 'div' );

		// BaseTemplate::printTrail() stuff (has no get version)
		// Required for RL to run
		$html .= MWDebug::getDebugHTML( $this->getSkin()->getContext() );
		$html .= $this->get( 'bottomscripts' );
		$html .= $this->get( 'reporttime' );

		$html .= Html::closeElement( 'body' );
		$html .= Html::closeElement( 'html' );

		// The unholy echo
		echo $html;
	}

	public function getHeaderUpper() {
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();
		// Preserve standard username label to allow customisation (T215822)
		$userName = $personalTools['userpage']['links'][0]['text'] ?? $user->getName();
		
		$contentText = '';
		foreach ( $personalTools as $key => $item ) {
			$contentText .= Html::rawElement(
				'a', 
				['href' => $item['links'][0]['href'], 'id' => $item['links'][0]['single-id']],
				 $item['links'][0]['text']
			);
		}

		$pageTools = Html::rawElement('div',['id' => 'sidebar-button', 'class' => 'sidebar-button']);
		$list = ['namespaces', 'page-primary', 'variants'];
		foreach ( $list as $key => $groupName ) {
			if ($this->pileOfTools[$groupName]) {
				foreach ( $this->pileOfTools[$groupName] as $key => $item ) {
					if ($item['href'] != $_SERVER['REQUEST_URI']) { // && $item['id'] != 'ca-nstab-main') {
						$pageTools .= Html::rawElement('div', 
						[
							'id' => $item['id'], 
							'class' => 'header-upper-item'
						], 
						Html::rawElement('a', ['href' => $item['href']], $item['text']));
					}
				}
			}
			
		}

		// foreach ( $this->pileOfTools['more'] as $key => $item ) {
		// 	$pageTools .= Html::rawElement('div', ['id' => $item['id'], 'class' => 'header-upper-item'], 
		// 	Html::rawElement('a', ['href' => $item['href']], $item['text']));
		// }
		
		return Html::rawElement('div', ['class' => 'mw-header-upper'],
			$pageTools .
			Html::rawElement('div', ['class' => 'spacer']) .
			Html::rawElement('div', ['class' => 'mw-header-personal-tools'], $contentText)
		);
	}

	public function getHeaderUpperMobile() {
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();
		// Preserve standard username label to allow customisation (T215822)
		$userName = $personalTools['userpage']['links'][0]['text'] ?? $user->getName();
		
		$contentText = '';
		foreach ( $personalTools as $key => $item ) {
			$contentText .= Html::rawElement(
				'a', 
				['href' => $item['links'][0]['href'], 'id' => $item['links'][0]['single-id']],
				 $item['links'][0]['text']
			);
		}

		$pageTools = '';
		$list = ['namespaces', 'page-primary', 'variants'];
		foreach ( $list as $key => $groupName ) {
			if ($this->pileOfTools[$groupName]) {
				foreach ( $this->pileOfTools[$groupName] as $key => $item ) {
					if ($item['href'] != $_SERVER['REQUEST_URI'] && $item['id'] != 'ca-nstab-main') {
						$pageTools .= Html::rawElement('a', ['href' => $item['href']], $item['text']);
					}
				}
			}
			
		}
		$siteTools= '';
		foreach ( $this->sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;
			$div = '';
			foreach ( $content['content'] as $key => $item ) {
				if (array_key_exists('text', $item)) {
					$div .= Html::rawElement('a', ['href' => $item['href']], $item['text']);
				}// else {
				//	$href = $item['href'];
				//	$ci = strpos($href, ':');
				//	$fs = strpos($href, '/', $ci);
				//	$itemName = '';
				//	if ($fs === false) {
				//		$itemName .= substr($href, $ci + 1);
				//	} else {
				//		$itemName .= substr($href, $ci + 1, $fs - $ci - 1);
				//	}
				//	$itemName = preg_replace('/([a-z])([A-Z])/s','$1 $2', $itemName);
				//	$div .= Html::rawElement('a', ['href' => $item['href']], $itemName);
				//}
			}
			$siteTools .= Html::rawElement('div', ['class' => 'menu-block'], $div);
		};
		$menuContent = Html::rawElement('div', ['class' => 'hamburger-menu-content'], 
			Html::rawElement('div', ['class' => 'menu-block'], $pageTools) .
			Html::rawElement('div', ['class' => 'menu-block'], $contentText) .
			$siteTools
		);
		
		return Html::rawElement('div', ['class' => 'mw-header-upper-mobile'],
			Html::rawElement('a', ['href' => $this->data['nav_urls']['mainpage']['href'], 'class'=>'logo-text'], 'BÁCH KHOA TOÀN THƯ VIỆT NAM') .
			Html::rawElement('div', ['class' => 'hamburger-menu-icon', 'id' => 'hamburger-menu-icon'], '') .
			Html::rawElement('div', ['class' => 'hamburger-menu', 'id' => 'hamburger-menu'], $menuContent)
		);
	}

	public function getHeaderLower() {
		$alphabet = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '#'];
		$alphabetSearch = '';
		foreach ( $alphabet as $key => $item ) {
			$alphabetSearch .= Html::rawElement('div', ['class' => 'alphabet-item'], 
				Html::rawElement('a', ['href' => 'https://bktt.vn/index.php/Special:AllPages?from='.$item.'&to=&namespace=0'], $item)
			);
		}
		$notMainPage = ' not-main-page-lower';
		if ($this->getSkin()->getTitle()->isMainPage()) {
			$notMainPage = '';
		}

		return Html::rawElement('div', ['class' => 'mw-header-lower' .$notMainPage], 
			Html::rawElement('a', ['href' => $this->data['nav_urls']['mainpage']['href'], 'class'=>'logo-text'], 'BÁCH KHOA TOÀN THƯ VIỆT NAM') .
			$this->getSearch() .
			$alphabetSearch
		);
	}

	/**
	 * Generate the page content block
	 * Broken out here due to the excessive indenting, or stuff.
	 *
	 * @return string html
	 */
	protected function getContentBlock() {
		$title = Html::rawElement('div', ['class' => 'page-title'], $this->get( 'title' ));
		if ($this->getSkin()->getTitle()->isMainPage()) {
			$title = Html::rawElement('div');
		}
		$html = Html::rawElement(
			'div',
			[ 'id' => 'content', 'class' => 'mw-body',  'role' => 'main' ],
			$this->getSiteNotices() .
			$this->getIndicators() .
			Html::rawElement( 'div', [ 'id' => 'bodyContentOuter' ],
				Html::rawElement( 'div', [ 'id' => 'siteSub' ], $this->getMsg( 'tagline' )->parse() ) .
				$this->getClear() .
				Html::rawElement( 'div', [ 'class' => 'mw-body-content', 'id' => 'bodyContent' ],
					$title .
					$this->getContentSub() .
					$this->get( 'bodytext' ) .
					$this->getClear()
				)
			)
		);
		return Html::rawElement( 'div', [ 'id' => 'mw-content' ], $html );
	}

	/**
	 * Generates a block of navigation links with a header
	 * This is some random fork of some random fork of what was supposed to be in core. Latest
	 * version copied out of MonoBook, probably. (20190719)
	 *
	 * @param string $name
	 * @param array|string $content array of links for use with makeListItem, or a block of text
	 *        Expected array format:
	 * 	[
	 * 		$name => [
	 * 			'links' => [ '0' =>
	 * 				[
	 * 					'href' => ...,
	 * 					'single-id' => ...,
	 * 					'text' => ...
	 * 				]
	 * 			],
	 * 			'id' => ...,
	 * 			'active' => ...
	 * 		],
	 * 		...
	 * 	]
	 * @param null|string|array|bool $msg
	 * @param array $setOptions miscellaneous overrides, see below
	 *
	 * @return string html
	 */
	protected function getPortlet( $name, $content, $msg = null, $setOptions = [] ) {
		// random stuff to override with any provided options
		$options = array_merge( [
			'role' => 'navigation',
			// extra classes/ids
			'id' => 'p-' . $name,
			'class' => [ 'mw-portlet', 'emptyPortlet' => !$content ],
			'extra-classes' => '',
			'body-id' => null,
			'body-class' => 'mw-portlet-body',
			'body-extra-classes' => '',
			// wrapper for individual list items
			'text-wrapper' => [ 'tag' => 'span' ],
			// option to stick arbitrary stuff at the beginning of the ul
			'list-prepend' => ''
		], $setOptions );

		// Handle the different $msg possibilities
		if ( $msg === null ) {
			$msg = $name;
			$msgParams = [];
		} elseif ( is_array( $msg ) ) {
			$msgString = array_shift( $msg );
			$msgParams = $msg;
			$msg = $msgString;
		} else {
			$msgParams = [];
		}
		$msgObj = $this->getMsg( $msg, $msgParams );
		if ( $msgObj->exists() ) {
			$msgString = $msgObj->parse();
		} else {
			$msgString = htmlspecialchars( $msg );
		}

		$labelId = Sanitizer::escapeIdForAttribute( "p-$name-label" );

		if ( is_array( $content ) ) {
			$contentText = Html::openElement( 'ul',
				[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ]
			);
			$contentText .= $options['list-prepend'];
			foreach ( $content as $key => $item ) {
				if ( is_array( $options['text-wrapper'] ) ) {
					$contentText .= $this->makeListItem(
						$key,
						$item,
						[ 'text-wrapper' => $options['text-wrapper'] ]
					);
				} else {
					$contentText .= $this->makeListItem(
						$key,
						$item
					);
				}
			}
			$contentText .= Html::closeElement( 'ul' );
		} else {
			$contentText = $content;
		}

		$divOptions = [
			'role' => $options['role'],
			'class' => $this->mergeClasses( $options['class'], $options['extra-classes'] ),
			'id' => Sanitizer::escapeIdForAttribute( $options['id'] ),
			'title' => Linker::titleAttrib( $options['id'] ),
			'aria-labelledby' => $labelId
		];
		$labelOptions = [
			'id' => $labelId,
			'lang' => $this->get( 'userlang' ),
			'dir' => $this->get( 'dir' )
		];

		$bodyDivOptions = [
			'class' => $this->mergeClasses( $options['body-class'], $options['body-extra-classes'] )
		];
		if ( is_string( $options['body-id'] ) ) {
			$bodyDivOptions['id'] = $options['body-id'];
		}

		$html = Html::rawElement( 'div', $divOptions,
			Html::rawElement( 'h3', $labelOptions, $msgString ) .
			Html::rawElement( 'div', $bodyDivOptions,
				$contentText .
				$this->getAfterPortlet( $name )
			)
		);

		return $html;
	}

	/**
	 * Helper function for getPortlet
	 *
	 * Merge all provided css classes into a single array
	 * Account for possible different input methods matching what Html::element stuff takes
	 *
	 * @param string|array $class base portlet/body class
	 * @param string|array $extraClasses any extra classes to also include
	 *
	 * @return array all classes to apply
	 */
	protected function mergeClasses( $class, $extraClasses ) {
		if ( !is_array( $class ) ) {
			$class = [ $class ];
		}
		if ( !is_array( $extraClasses ) ) {
			$extraClasses = [ $extraClasses ];
		}

		return array_merge( $class, $extraClasses );
	}

	/**
	 * Sidebar chunk containing one or more portlets
	 *
	 * @param string $id
	 * @param string $headerMessage
	 * @param string $content
	 * @param array $classes
	 *
	 * @return string html
	 */
	protected function getSidebarChunk( $id, $headerMessage, $content, $classes = [] ) {
		$html = '';

		$html .= Html::rawElement(
			'div',
			[
				'id' => Sanitizer::escapeId( $id ),
				'class' => array_merge( [ 'sidebar-chunk' ], $classes )
			],
			Html::rawElement( 'h2', [],
				Html::element( 'span', [],
					$this->getMsg( $headerMessage )->text()
				)
			) .
			Html::rawElement( 'div', [ 'class' => 'sidebar-inner' ], $content )
		);

		return $html;
	}

	/**
	 * The search box at the top
	 *
	 * @return string html
	 */
	protected function getSearch() {
		$html = '';

		$html .= Html::openElement( 'div', [  'id' => 'p-search' ] );

		$html .= Html::rawElement(
			'h3',
			[ 'lang' => $this->get( 'userlang' ), 'dir' => $this->get( 'dir' ) ],
			Html::rawElement( 'label', [ 'for' => 'searchInput' ], $this->getMsg( 'search' )->escaped() )
		);

		$html .= Html::rawElement( 'form', [ 'action' => $this->get( 'wgScript' ), 'id' => 'searchform' ],
			Html::rawElement( 'div', [ 'id' => 'simpleSearch' ],
				$this->makeSearchInput( ['id' => 'searchInput', 'placeholder' => 'Tìm ở Bách khoa Toàn thư Việt Nam ...'] ) .
				Html::hidden( 'title', $this->get( 'searchtitle' ) ) .
				//$this->makeSearchButton(
				//	'fulltext',
				//	[ 'id' => 'mw-searchButton', 'class' => 'searchButton mw-fallbackSearchButton' ]
				//) .
				$this->makeSearchButton(
					'go',
					[ 'id' => 'searchButton', 'class' => 'searchButton' ]
				)
			)
		);

		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * Left sidebar navigation, usually
	 *
	 * @return string html
	 */
	protected function getMainNavigation() {
		$html = '';

		// Already hardcoded into header
		$this->sidebar['SEARCH'] = false;
		// Parsed as part of pageTools
		$this->sidebar['TOOLBOX'] = false;
		// Forcibly removed to separate chunk
		$this->sidebar['LANGUAGES'] = false;

		foreach ( $this->sidebar as $name => $content ) {
			if ( $content === false ) {
				continue;
			}
			// Numeric strings gets an integer when set as key, cast back - T73639
			$name = (string)$name;
			$html .= $this->getPortlet( $name, $content['content'] );
		}

		$html = $this->getSidebarChunk( 'site-navigation', 'navigation', $html );

		return $html;
	}

	/**
	 * Page tools in sidebar
	 *
	 * @return string html
	 */
	protected function getPageToolSidebar() {
		$pageTools = '';
		$pageTools .= $this->getPortlet(
			'cactions',
			$this->pileOfTools['page-secondary'],
			'timeless-pageactions'
		);
		$pageTools .= $this->getPortlet(
			'tb',
			$this->pileOfTools['general'],
			'timeless-sitetools'
		);
		$pageTools .= $this->getPortlet(
			'userpagetools',
			$this->pileOfTools['user'],
			'timeless-userpagetools'
		);
		$pageTools .= $this->getPortlet(
			'pagemisc',
			$this->pileOfTools['page-tertiary'],
			'timeless-pagemisc'
		);
		if ( isset( $this->collectionPortlet ) ) {
			$pageTools .= $this->getPortlet(
				'coll-print_export',
				$this->collectionPortlet['content']
			);
		}

		return $this->getSidebarChunk( 'page-tools', 'timeless-pageactions', $pageTools );
	}

	/**
	 * Personal/user links portlet for header
	 *
	 * @return array [ html, class ], where class is an extra class to apply to surrounding objects
	 * (for width adjustments)
	 */
	protected function getUserLinks() {
		$user = $this->getSkin()->getUser();
		$personalTools = $this->getPersonalTools();
		// Preserve standard username label to allow customisation (T215822)
		$userName = $personalTools['userpage']['links'][0]['text'] ?? $user->getName();

		$html = '';
		$extraTools = [];

		// Remove Echo badges
		if ( isset( $personalTools['notifications-alert'] ) ) {
			$extraTools['notifications-alert'] = $personalTools['notifications-alert'];
			unset( $personalTools['notifications-alert'] );
		}
		if ( isset( $personalTools['notifications-notice'] ) ) {
			$extraTools['notifications-notice'] = $personalTools['notifications-notice'];
			unset( $personalTools['notifications-notice'] );
		}
		$class = empty( $extraTools ) ? '' : 'extension-icons';

		// Re-label some messages
		if ( isset( $personalTools['userpage'] ) ) {
			$personalTools['userpage']['links'][0]['text'] = $this->getMsg( 'timeless-userpage' )->text();
		}
		if ( isset( $personalTools['mytalk'] ) ) {
			$personalTools['mytalk']['links'][0]['text'] = $this->getMsg( 'timeless-talkpage' )->text();
		}

		// Labels
		if ( $user->isLoggedIn() ) {
			$dropdownHeader = $userName;
			$headerMsg = [ 'timeless-loggedinas', $userName ];
		} else {
			$dropdownHeader = $this->getMsg( 'timeless-anonymous' )->text();
			$headerMsg = 'timeless-notloggedin';
		}
		$html .= Html::openElement( 'div', [ 'id' => 'user-tools' ] );

		$html .= Html::rawElement( 'div', [ 'id' => 'personal' ],
			Html::rawElement( 'h2', [],
				Html::element( 'span', [], $dropdownHeader )
			) .
			Html::rawElement( 'div', [ 'id' => 'personal-inner', 'class' => 'dropdown' ],
				$this->getPortlet( 'personal', $personalTools, $headerMsg )
			)
		);

		// Extra icon stuff (echo etc)
		if ( !empty( $extraTools ) ) {
			$iconList = '';
			foreach ( $extraTools as $key => $item ) {
				$iconList .= $this->makeListItem( $key, $item );
			}

			$html .= Html::rawElement(
				'div',
				[ 'id' => 'personal-extra', 'class' => 'p-body' ],
				Html::rawElement( 'ul', [], $iconList )
			);
		}

		$html .= Html::closeElement( 'div' );

		return [
			'html' => $html,
			'class' => $class
		];
	}

	/**
	 * Notices that may appear above the firstHeading
	 *
	 * @return string html
	 */
	protected function getSiteNotices() {
		$html = '';

		if ( $this->data['sitenotice'] ) {
			$html .= Html::rawElement( 'div', [ 'id' => 'siteNotice' ], $this->get( 'sitenotice' ) );
		}
		if ( $this->data['newtalk'] ) {
			$html .= Html::rawElement( 'div', [ 'class' => 'usermessage' ], $this->get( 'newtalk' ) );
		}

		return $html;
	}

	/**
	 * Links and information that may appear below the firstHeading
	 *
	 * @return string html
	 */
	protected function getContentSub() {
		$html = '';

		$html .= Html::openElement( 'div', [ 'id' => 'contentSub' ] );
		if ( $this->data['subtitle'] ) {
			$html .= $this->get( 'subtitle' );
		}
		if ( $this->data['undelete'] ) {
			$html .= $this->get( 'undelete' );
		}
		$html .= Html::closeElement( 'div' );

		return $html;
	}

	/**
	 * The data after content, catlinks, and potential other stuff that may appear within
	 * the content block but after the main content
	 *
	 * @return string html
	 */
	protected function getAfterContent() {
		$html = '';

		if ( $this->data['catlinks'] || $this->data['dataAfterContent'] ) {
			$html .= Html::openElement( 'div', [ 'id' => 'content-bottom-stuff' ] );
			if ( $this->data['catlinks'] ) {
				$html .= $this->get( 'catlinks' );
			}
			if ( $this->data['dataAfterContent'] ) {
				$html .= $this->get( 'dataAfterContent' );
			}
			$html .= Html::closeElement( 'div' );
		}

		return $html;
	}

	/**
	 * Generate pile of all the tools
	 *
	 * We can make a few assumptions based on where a tool started out:
	 *     If it's in the cactions region, it's a page tool, probably primary or secondary
	 *     ...that's all I can think of
	 *
	 * @return array of array of tools information (portlet formatting)
	 */
	protected function getPageTools() {
		$title = $this->getSkin()->getTitle();
		$namespace = $title->getNamespace();

		$sortedPileOfTools = [
			'namespaces' => [],
			'page-primary' => [],
			'page-secondary' => [],
			'user' => [],
			'page-tertiary' => [],
			'more' => [],
			'general' => []
		];

		// Tools specific to the page
		$pileOfEditTools = [];
		foreach ( $this->data['content_navigation'] as $navKey => $navBlock ) {
			// Just use namespaces items as they are
			if ( $navKey == 'namespaces' ) {
				if ( $namespace < 0 && count( $navBlock ) < 2 ) {
					// Put special page ns_pages in the more pile so they're not so lonely
					$sortedPileOfTools['page-tertiary'] = $navBlock;
				} else {
					$sortedPileOfTools['namespaces'] = $navBlock;
				}
			} elseif ( $navKey == 'variants' ) {
				// wat
				$sortedPileOfTools['variants'] = $navBlock;
			} else {
				$pileOfEditTools = array_merge( $pileOfEditTools, $navBlock );
			}
		}

		// Tools that may be general or page-related (typically the toolbox)
		$pileOfTools = $this->getToolbox();
		if ( $namespace >= 0 ) {
			$pileOfTools['pagelog'] = [
				'text' => $this->getMsg( 'timeless-pagelog' )->text(),
				'href' => SpecialPage::getTitleFor( 'Log' )->getLocalURL(
					[ 'page' => $title->getPrefixedText() ]
				),
				'id' => 't-pagelog'
			];
		}

		// Mobile toggles
		$pileOfTools['more'] = [
			'text' => $this->getMsg( 'timeless-more' )->text(),
			'id' => 'ca-more',
			'class' => 'dropdown-toggle'
		];
		if ( $this->data['language_urls'] !== false || $sortedPileOfTools['variants'] ) {
			$pileOfTools['languages'] = [
				'text' => $this->getMsg( 'timeless-languages' )->escaped(),
				'id' => 'ca-languages',
				'class' => 'dropdown-toggle'
			];
		}

		// This is really dumb, and you're an idiot for doing it this way.
		// Obviously if you're not the idiot who did this, I don't mean you.
		foreach ( $pileOfEditTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( in_array( $navKey, [
				'watch',
				'unwatch',
				'delete',
				'rename',
				'protect',
				'unprotect',
				'move'
			] ) ) {
				$currentSet = 'page-secondary';
			} else {
				// Catch random extension ones?
				$currentSet = 'page-primary';
			}
			$sortedPileOfTools[$currentSet][$navKey] = $navBlock;
		}
		foreach ( $pileOfTools as $navKey => $navBlock ) {
			$currentSet = null;

			if ( $navKey === 'contributions' ) {
				$currentSet = 'page-primary';
			} elseif ( in_array( $navKey, [
				'blockip',
				'userrights',
				'log',
				'emailuser'

			] ) ) {
				$currentSet = 'user';
			} elseif ( in_array( $navKey, [
				'whatlinkshere',
				'print',
				'info',
				'pagelog',
				'recentchangeslinked',
				'permalink',
				'wikibase',
				'cite'
			] ) ) {
				$currentSet = 'page-tertiary';
			} elseif ( in_array( $navKey, [
				'more',
				'languages'
			] ) ) {
				$currentSet = 'more';
			} else {
				$currentSet = 'general';
			}
			$sortedPileOfTools[$currentSet][$navKey] = $navBlock;
		}

		// Extra sorting for Extension:ProofreadPage namespace items
		$tabs = [
			'proofreadPagePrevLink',
			// This is the order we want them in...
			'proofreadPageScanLink',
			'proofreadPageIndexLink',
			'proofreadPageNextLink',
		];
		foreach ( $tabs as $tab ) {
			if ( isset( $sortedPileOfTools['namespaces'][$tab] ) ) {
				$toMove = $sortedPileOfTools['namespaces'][$tab];
				unset( $sortedPileOfTools['namespaces'][$tab] );

				// add a hover tooltip, mostly for the icons
				$toMove['title'] = $toMove['text'];

				if ( $tab === 'proofreadPagePrevLink' ) {
					// prev at start
					$sortedPileOfTools['namespaces'] = array_merge(
						[ $tab => $toMove ],
						$sortedPileOfTools['namespaces']
					);
				} else {
					// move others to end
					$sortedPileOfTools['namespaces'][$tab] = $toMove;
				}
			}
		}

		return $sortedPileOfTools;
	}

	/**
	 * Categories for the sidebar
	 *
	 * Assemble an array of categories. This doesn't show any categories for the
	 * action=history view, but that behaviour is consistent with other skins.
	 *
	 * @return string html
	 */
	protected function getCategories() {
		$skin = $this->getSkin();
		$catList = '';
		$html = '';

		$allCats = $skin->getOutput()->getCategoryLinks();
		if ( !empty( $allCats ) ) {
			if ( !empty( $allCats['normal'] ) ) {
				$catHeader = 'categories';
				$catList .= $this->getCatList(
					$allCats['normal'],
					'normal-catlinks',
					'mw-normal-catlinks',
					'categories'
				);
			} else {
				$catHeader = 'hidden-categories';
			}

			if ( isset( $allCats['hidden'] ) ) {
				$hiddenCatClass = [ 'mw-hidden-catlinks' ];
				if ( $skin->getUser()->getBoolOption( 'showhiddencats' ) ) {
					$hiddenCatClass[] = 'mw-hidden-cats-user-shown';
				} elseif ( $skin->getTitle()->getNamespace() == NS_CATEGORY ) {
					$hiddenCatClass[] = 'mw-hidden-cats-ns-shown';
				} else {
					$hiddenCatClass[] = 'mw-hidden-cats-hidden';
				}
				$catList .= $this->getCatList(
					$allCats['hidden'],
					'hidden-catlinks',
					$hiddenCatClass,
					[ 'hidden-categories', count( $allCats['hidden'] ) ]
				);
			}
		}

		if ( $catList !== '' ) {
			$html = $this->getSidebarChunk( 'catlinks-sidebar', $catHeader, $catList );
		}

		return $html;
	}

	/**
	 * List of categories
	 *
	 * @param array $list
	 * @param string $id
	 * @param string|array $class
	 * @param string|array $message i18n message name or an array of [ message name, params ]
	 *
	 * @return string html
	 */
	protected function getCatList( $list, $id, $class, $message ) {
		$html = Html::openElement( 'div', [ 'id' => "sidebar-{$id}", 'class' => $class ] );

		$makeLinkItem = function ( $linkHtml ) {
			return Html::rawElement( 'li', [], $linkHtml );
		};

		$categoryItems = array_map( $makeLinkItem, $list );

		$categoriesHtml = Html::rawElement( 'ul',
			[],
			implode( '', $categoryItems )
		);

		$html .= $this->getPortlet( $id, $categoriesHtml, $message );

		$html .= Html::closeElement( 'div' );

		return $html;
	}

}
