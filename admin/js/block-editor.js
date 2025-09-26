(function() {
	const { registerBlockType } = wp.blocks;
	const { InspectorControls } = wp.blockEditor;
	const { PanelBody, TextControl, SelectControl } = wp.components;
	const { __ } = wp.i18n;
	const { createElement: el } = wp.element;

	registerBlockType('listo/store-locator', {
		title: __('Listo Store Locator', 'listo-store-locator'),
		description: __('Konum listesi göstermek için kullanın', 'listo-store-locator'),
		icon: 'location-alt',
		category: 'widgets',
		keywords: [
			__('listo', 'listo-store-locator'),
			__('store', 'listo-store-locator'),
			__('location', 'listo-store-locator'),
			__('konum', 'listo-store-locator'),
			__('mağaza', 'listo-store-locator')
		],

		attributes: {
			limit: {
				type: 'number',
				default: 10
			},
			country: {
				type: 'string',
				default: ''
			},
			city: {
				type: 'string',
				default: ''
			},
			district: {
				type: 'string',
				default: ''
			}
		},

		edit: function(props) {
			const { attributes, setAttributes } = props;
			const { limit, country, city, district } = attributes;

			return [
				// Inspector Controls (Sağ taraf ayarlar)
				el(InspectorControls, {},
				   el(PanelBody, {
						  title: __('Listo Ayarları', 'listo-store-locator'),
						  initialOpen: true
					  },
					  el(TextControl, {
						  label: __('Gösterilecek Konum Sayısı', 'listo-store-locator'),
						  value: limit,
						  onChange: function(value) {
							  setAttributes({ limit: parseInt(value) || 10 });
						  },
						  type: 'number',
						  min: 1,
						  max: 100
					  }),

					  el(SelectControl, {
						  label: __('Ülke Filtresi', 'listo-store-locator'),
						  value: country,
						  options: [
							  { label: 'Tümü', value: '' },
							  { label: 'Türkiye', value: 'turkey' },
							  { label: 'Amerika', value: 'usa' },
							  { label: 'Almanya', value: 'germany' }
						  ],
						  onChange: function(value) {
							  setAttributes({ country: value });
						  }
					  }),

					  el(SelectControl, {
						  label: __('İl Filtresi', 'listo-store-locator'),
						  value: city,
						  options: [
							  { label: 'Tümü', value: '' },
							  { label: 'İstanbul', value: 'istanbul' },
							  { label: 'Ankara', value: 'ankara' },
							  { label: 'İzmir', value: 'izmir' },
							  { label: 'Bursa', value: 'bursa' }
						  ],
						  onChange: function(value) {
							  setAttributes({ city: value });
						  }
					  }),

					  el(SelectControl, {
						  label: __('İlçe Filtresi', 'listo-store-locator'),
						  value: district,
						  options: [
							  { label: 'Tümü', value: '' },
							  { label: 'Kadıköy', value: 'kadikoy' },
							  { label: 'Beşiktaş', value: 'besiktas' },
							  { label: 'Şişli', value: 'sisli' },
							  { label: 'Üsküdar', value: 'uskudar' }
						  ],
						  onChange: function(value) {
							  setAttributes({ district: value });
						  }
					  })
				   )
				),

				// Editör içindeki görünüm
				el('div', {
					   className: 'listo-block-editor-preview',
					   style: {
						   border: '1px dashed #ccc',
						   padding: '20px',
						   textAlign: 'center',
						   backgroundColor: '#f9f9f9'
					   }
				   },
				   el('div', {
					   style: {
						   fontSize: '18px',
						   marginBottom: '10px'
					   }
				   }, '📍 Listo Store Locator'),

				   el('div', {
						  style: {
							  fontSize: '14px',
							  color: '#666'
						  }
					  },
					  __('Konum sayısı: ', 'listo-store-locator') + limit,
					  country ? ' | Ülke: ' + country : '',
					  city ? ' | İl: ' + city : '',
					  district ? ' | İlçe: ' + district : ''
				   ),

				   el('div', {
					   style: {
						   fontSize: '12px',
						   color: '#999',
						   marginTop: '10px'
					   }
				   }, __('Frontend\'te konum listesi burada görünecek', 'listo-store-locator'))
				)
			];
		},

		save: function() {
			// Server-side rendering kullanıyoruz, bu yüzden null döndür
			return null;
		}
	});
})();
