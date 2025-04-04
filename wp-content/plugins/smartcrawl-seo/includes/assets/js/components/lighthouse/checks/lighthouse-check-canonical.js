import React from 'react';
import LighthouseCheckItem from '../lighthouse-check-item';
import { __, sprintf } from '@wordpress/i18n';
import Notice from '../../notices/notice';
import { createInterpolateElement } from '@wordpress/element';
import LighthouseUtil from '../utils/lighthouse-util';
import LighthouseToggle from '../lighthouse-toggle';
import ConfigValues from '../../../es6/config-values';

export default class LighthouseCheckCanonical extends React.Component {
	static defaultProps = {
		id: 'canonical',
	};

	render() {
		return (
			<LighthouseCheckItem
				id={this.props.id}
				successTitle={__(
					'Document has a valid rel=canonical',
					'smartcrawl-seo'
				)}
				failureTitle={__(
					'Document does not have a valid rel=canonical',
					'smartcrawl-seo'
				)}
				successDescription={this.successDescription()}
				failureDescription={this.failureDescription()}
				copyDescription={() => this.copyDescription()}
				actionButton={LighthouseUtil.editHomepageButton()}
			/>
		);
	}

	commonDescription() {
		return (
			<React.Fragment>
				<strong>{__('Overview', 'smartcrawl-seo')}</strong>
				<p>
					{__(
						'When multiple pages have similar content, search engines consider them duplicate versions of the same page. For example, desktop and mobile versions of a product page are often considered duplicates.',
						'smartcrawl-seo'
					)}
				</p>
				<p>
					{__(
						'Search engines select one of the pages as the canonical, or primary, version and crawl that one more. Valid canonical links let you tell search engines which version of a page to crawl and display to users in search results.',
						'smartcrawl-seo'
					)}
				</p>
			</React.Fragment>
		);
	}

	successDescription() {
		return (
			<React.Fragment>
				<div className="wds-lh-section">{this.commonDescription()}</div>

				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="success"
						icon="sui-icon-info"
						message={__(
							'We found a valid canonical meta tag.',
							'smartcrawl-seo'
						)}
					/>
				</div>
			</React.Fragment>
		);
	}

	failureDescription() {
		return (
			<React.Fragment>
				<div className="wds-lh-section">
					{this.commonDescription()}

					<p>
						{__(
							'Using canonical links has many advantages:',
							'smartcrawl-seo'
						)}
					</p>
					<ul>
						<li>
							{__(
								'It helps search engines consolidate multiple URLs into a single, preferred URL. For example, if other sites put query parameters on the ends of links to your page, search engines consolidate those URLs to your preferred version.',
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{__(
								'It simplifies tracking methods. Tracking one URL is easier than tracking many.',
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{__(
								'It improves the page ranking of syndicated content by consolidating the syndicated links to your original content back to your preferred URL.',
								'smartcrawl-seo'
							)}
						</li>
					</ul>
				</div>

				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="warning"
						icon="sui-icon-info"
						message={__(
							'We couldn’t detect a valid canonical meta tag.',
							'smartcrawl-seo'
						)}
					/>
					<p>
						{__(
							'It’s highly recommended to always set a single canonical URL for every webpage to ensure search engines never get confused and always have the original source of truth content.',
							'smartcrawl-seo'
						)}
					</p>
				</div>

				<div className="wds-lh-section">
					<strong>
						{__(
							'How to add canonical links to your pages',
							'smartcrawl-seo'
						)}
					</strong>
					<p>
						{__(
							'For your homepage, set the canonical URL using the Titles & Meta settings area. For individual pages we automatically generate a canonical URL based off your base site URL, but you can override that on a per post basis using the Post Editor SEO widget.',
							'smartcrawl-seo'
						)}
					</p>
					<p>
						{createInterpolateElement(
							sprintf(
								// translators: %s: plugin title
								__(
									'To help ensure your SEO efforts are up to snuff, see our blog post, <a>WordPress Canonicalization Made Simple With <strong>%s</strong></a>, for an easy setup guide to get canonicals right.',
									'smartcrawl-seo'
								),
								ConfigValues.get('plugin_title', 'admin')
							),
							{
								a: (
									<a
										href="https://wpmudev.com/blog/wordpress-canonicalization-guide/"
										target="_blank"
										rel="noreferrer"
									/>
								),
								strong: <strong />,
							}
						)}
					</p>
				</div>

				<LighthouseToggle text={__('Read More - Guidelines')}>
					<strong>{__('General guidelines', 'smartcrawl-seo')}</strong>
					<ul>
						<li>
							{__(
								'Make sure that the canonical URL is valid.',
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{createInterpolateElement(
								__(
									'Use secure <a>HTTPS</a> canonical URLs rather than HTTP whenever possible.',
									'smartcrawl-seo'
								),
								{
									a: (
										<a
											href="https://developers.google.com/search/docs/advanced/security/https"
											target="_blank"
											rel="noreferrer"
										/>
									),
								}
							)}
						</li>
						<li>
							{createInterpolateElement(
								__(
									"If you use <a>hreflang links</a> to serve different versions of a page depending on a user's language or country, make sure that the canonical URL points to the proper page for that respective language or country.",
									'smartcrawl-seo'
								),
								{
									a: (
										<a
											href="https://developers.google.com/search/docs/advanced/crawling/localized-versions?hl=en#expandable-1"
											target="_blank"
											rel="noreferrer"
										/>
									),
								}
							)}
						</li>
						<li>
							{__(
								"Don't point the canonical URL to a different domain. Yahoo and Bing don't allow this.",
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{__(
								"Don't point lower-level pages to the site's root page unless their content is the same.",
								'smartcrawl-seo'
							)}
						</li>
					</ul>

					<p>
						{createInterpolateElement(
							"See <a>Google's Consolidate duplicate URLs</a> page.",
							{
								a: (
									<a
										href="https://developers.google.com/search/docs/advanced/crawling/consolidate-duplicate-urls"
										target="_blank"
										rel="noreferrer"
									/>
								),
							}
						)}
					</p>
				</LighthouseToggle>
			</React.Fragment>
		);
	}

	copyDescription() {
		return (
			sprintf(
				// translators: %s: Device label.
				__('Tested Device: %s', 'smartcrawl-seo'),
				LighthouseUtil.getDeviceLabel()
			) +
			'\n' +
			__('Audit Type: Content audits', 'smartcrawl-seo') +
			'\n\n' +
			__(
				'Failing Audit: Document does not have a valid rel=canonical',
				'smartcrawl-seo'
			) +
			'\n\n' +
			__(
				'Status: We couldn’t detect a valid canonical meta tag.',
				'smartcrawl-seo'
			) +
			'\n' +
			__(
				'It’s highly recommended to always set a single canonical URL for every webpage to ensure search engines never get confused and always have the original source of truth content.',
				'smartcrawl-seo'
			) +
			'\n\n' +
			__('Overview:', 'smartcrawl-seo') +
			'\n' +
			__(
				'When multiple pages have similar content, search engines consider them duplicate versions of the same page. For example, desktop and mobile versions of a product page are often considered duplicates.',
				'smartcrawl-seo'
			) +
			'\n' +
			__(
				'Search engines select one of the pages as the canonical, or primary, version and crawl that one more. Valid canonical links let you tell search engines which version of a page to crawl and display to users in search results.',
				'smartcrawl-seo'
			) +
			'\n\n' +
			__('Using canonical links has many advantages:', 'smartcrawl-seo') +
			'\n' +
			__(
				'- It helps search engines consolidate multiple URLs into a single, preferred URL. For example, if other sites put query parameters on the ends of links to your page, search engines consolidate those URLs to your preferred version.',
				'smartcrawl-seo'
			) +
			'\n' +
			__(
				'- It simplifies tracking methods. Tracking one URL is easier than tracking many.',
				'smartcrawl-seo'
			) +
			'\n' +
			__(
				'- It improves the page ranking of syndicated content by consolidating the syndicated links to your original content back to your preferred URL.',
				'smartcrawl-seo'
			) +
			'\n\n' +
			createInterpolateElement(
				sprintf(
					// translators: %s: plugin title
					__(
						'For more information please check the SEO Audits section in <strong>%s</strong> plugin.',
						'smartcrawl-seo'
					),
					ConfigValues.get('plugin_title', 'admin')
				),
				{ strong: <strong /> }
			)
		);
	}
}
