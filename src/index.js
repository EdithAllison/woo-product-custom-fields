/**
 * External dependencies
 */
import { addFilter } from '@wordpress/hooks';
import { __ } from '@wordpress/i18n';
import { Dropdown } from '@wordpress/components';
import * as Woo from '@woocommerce/components';
import { Fragment } from '@wordpress/element';

/**
 * Internal dependencies
 */
import './index.scss';

const MyExamplePage = () => (
	<Fragment>
		<Woo.Section component="article">
			<Woo.SectionHeader title={__('Search', 'woo-product-field')} />
			<Woo.Search
				type="products"
				placeholder="Search for something"
				selected={[]}
				onChange={(items) => setInlineSelect(items)}
				inlineTags
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={__('Dropdown', 'woo-product-field')} />
			<Dropdown
				renderToggle={({ isOpen, onToggle }) => (
					<Woo.DropdownButton
						onClick={onToggle}
						isOpen={isOpen}
						labels={['Dropdown']}
					/>
				)}
				renderContent={() => <p>Dropdown content here</p>}
			/>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader
				title={__('Pill shaped container', 'woo-product-field')}
			/>
			<Woo.Pill className={'pill'}>
				{__('Pill Shape Container', 'woo-product-field')}
			</Woo.Pill>
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={__('Spinner', 'woo-product-field')} />
			<Woo.H>I am a spinner!</Woo.H>
			<Woo.Spinner />
		</Woo.Section>

		<Woo.Section component="article">
			<Woo.SectionHeader title={__('Datepicker', 'woo-product-field')} />
			<Woo.DatePicker
				text={__('I am a datepicker!', 'woo-product-field')}
				dateFormat={'MM/DD/YYYY'}
			/>
		</Woo.Section>
	</Fragment>
);

addFilter('woocommerce_admin_pages_list', 'woo-product-field', (pages) => {
	pages.push({
		container: MyExamplePage,
		path: '/woo-product-field',
		breadcrumbs: [__('Woo Product Field', 'woo-product-field')],
		navArgs: {
			id: 'woo_product_field',
		},
	});

	return pages;
});
