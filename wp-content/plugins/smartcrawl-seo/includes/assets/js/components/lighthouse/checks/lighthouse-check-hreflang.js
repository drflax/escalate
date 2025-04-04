import React from 'react';
import { createInterpolateElement } from '@wordpress/element';
import Notice from '../../notices/notice';
import { __, sprintf } from '@wordpress/i18n';
import LighthouseUtil from '../utils/lighthouse-util';
import LighthouseCheckItem from '../lighthouse-check-item';
import LighthouseTable from '../tables/lighthouse-table';
import Button from '../../button';
import LighthouseToggle from '../lighthouse-toggle';
import ConfigValues from '../../../es6/config-values';

export default class LighthouseCheckHreflang extends React.Component {
	static defaultProps = {
		id: 'hreflang',
	};

	render() {
		return (
			<LighthouseCheckItem
				id={this.props.id}
				successTitle={__(
					'Document has a valid hreflang',
					'smartcrawl-seo'
				)}
				failureTitle={__(
					"Document doesn't have a valid hreflang",
					'smartcrawl-seo'
				)}
				successDescription={this.successDescription()}
				failureDescription={this.failureDescription()}
				copyDescription={() => this.copyDescription()}
				actionButton={this.getActionButton()}
			/>
		);
	}

	commonDescription() {
		return (
			<div className="wds-lh-section">
				<strong>{__('Overview', 'smartcrawl-seo')}</strong>
				<p>
					{__(
						"Many sites provide different versions of a page based on a user's language or region. hreflang links tell search engines the URLs for all the versions of a page so that they can display the correct version for each language or region.",
						'smartcrawl-seo'
					)}
				</p>
			</div>
		);
	}

	successDescription() {
		return (
			<React.Fragment>
				{this.commonDescription()}
				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="success"
						icon="sui-icon-info"
						message={createInterpolateElement(
							__(
								'Document has a valid <strong>hreflang</strong>, nice work.',
								'smartcrawl-seo'
							),
							{
								strong: <strong />,
							}
						)}
					/>
				</div>
			</React.Fragment>
		);
	}

	failureDescription() {
		return (
			<React.Fragment>
				{this.commonDescription()}

				<div className="wds-lh-section">
					<strong>{__('Status', 'smartcrawl-seo')}</strong>
					<Notice
						type="warning"
						icon="sui-icon-info"
						message={__(
							"Document doesn't have a valid hreflang.",
							'smartcrawl-seo'
						)}
					/>

					{this.renderTable()}
				</div>

				<div className="wds-lh-section">
					<strong>
						{__(
							'How to define an hreflang link for each version of a page',
							'smartcrawl-seo'
						)}
					</strong>
					<ul>
						<li>
							<p
								dangerouslySetInnerHTML={{
									__html: sprintf(
										// translators: 1,2: <strong/>, 3: Link target, 4,6: Link urls, 5,7: Link texts.
										__(
											'%1$sMethod 1: Add hreflang Tag in WordPress Using a Multilingual Plugin.%2$s<br/>The best approach to building a multilingual WordPress site is by using a multilingual plugin. A multilingual WordPress plugin allows you to easily create and manage content in multiple languages using the same WordPress core software. Some examples: <a target="%3$s" href="%4$s">%5$s</a> or <a target="%3$s" href="%6$s">%7$s</a>.',
											'smartcrawl-seo'
										),
										'<strong>',
										'</strong>',
										'_blank',
										'https://polylang.pro/',
										__('Polylang', 'smartcrawl-seo'),
										'https://wpml.org/',
										__('WPML', 'smartcrawl-seo')
									),
								}}
							/>
						</li>

						<li>
							<p>
								{createInterpolateElement(
									__(
										'<strong>Method 2: Add hreflang Tags in WordPress Without Using a Multilingual Plugin</strong><br/>This method is for users who are not using a multilingual plugin to manage translations on their websites. First thing you need to do is install and activate the <a>hreflang Tags Lite plugin</a>. Next, you need to edit the post or page where you want to add the hreflang tag. On the post edit screen, you will notice a new metabox labeled hreflang tags.',
										'smartcrawl-seo'
									),
									{
										strong: <strong />,
										br: <br />,
										a: (
											<a
												href="https://wordpress.org/plugins/hreflang-tags-by-dcgws/"
												target="_blank"
												rel="noreferrer"
											/>
										),
									}
								)}
							</p>
						</li>
					</ul>
				</div>
				<LighthouseToggle
					text={__('Read More - Guidelines', 'smartcrawl-seo')}
				>
					<strong>
						{__('Guidelines for hreflang values', 'smartcrawl-seo')}
					</strong>
					<ul>
						<li>
							{__(
								'The hreflang value must always specify a language code.',
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{createInterpolateElement(
								__(
									'The language code must follow <a>ISO 639-1 format</a>.',
									'smartcrawl-seo'
								),
								{
									a: (
										<a
											href="https://en.wikipedia.org/wiki/ListOfISO639-1Codes"
											target="_blank"
											rel="noreferrer"
										/>
									),
								}
							)}
						</li>
						<li>
							{__(
								'The hreflang value can also include an optional regional code. For example, es-mx is for Spanish speakers in Mexico, while es-cl is for Spanish speakers in Chile.',
								'smartcrawl-seo'
							)}
						</li>
						<li>
							{createInterpolateElement(
								__(
									'The region code must follow the <a>ISO 3166-1 alpha-2 format</a>.',
									'smartcrawl-seo'
								),
								{
									a: (
										<a
											href="https://en.wikipedia.org/wiki/ISO3166-1Alpha-2"
											target="_blank"
											rel="noreferrer"
										/>
									),
								}
							)}
						</li>
					</ul>

					<p>
						{createInterpolateElement(
							__(
								"For more information, see Google's <a>Tell Google about localized versions of your page</a>.",
								'smartcrawl-seo'
							),
							{
								a: (
									<a href="https://developers.google.com/search/docs/advanced/crawling/localized-versions" />
								),
							}
						)}
					</p>
				</LighthouseToggle>
			</React.Fragment>
		);
	}

	renderTable() {
		return (
			<LighthouseTable
				id={this.props.id}
				header={[__('Source', 'smartcrawl-seo')]}
				rows={this.getRows()}
			/>
		);
	}

	getActionButton() {
		const url = LighthouseUtil.pluginInstallUrl();

		if (!url) {
			return '';
		}

		return (
			<Button
				href={url}
				icon="sui-icon-magnifying-glass-search"
				text={__('HREFLANG Plugins', 'smartcrawl-seo')}
			/>
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
				"Failing Audit: Document doesn't have a valid hreflang",
				'smartcrawl-seo'
			) +
			'\n\n' +
			__(
				"Status: Document doesn't have a valid hreflang.",
				'smartcrawl-seo'
			) +
			'\n\n' +
			LighthouseUtil.getFlattenedDetails(
				[__('Source', 'smartcrawl-seo')],
				this.getRows()
			) +
			__('Overview:', 'smartcrawl-seo') +
			'\n' +
			__(
				"Many sites provide different versions of a page based on a user's language or region. hreflang links tell search engines the URLs for all the versions of a page so that they can display the correct version for each language or region.",
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

	getRows() {
		const items = LighthouseUtil.getRawDetails(this.props.id)?.items;

		const rows = [];

		if (items) {
			items.forEach((item) => {
				rows.push([item.source?.snippet]);
			});
		}

		return rows;
	}
}
