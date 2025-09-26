# Listo - WordPress Store Locator

Professional WordPress Store Locator plugin for finding stores by location.

## 🚀 Features

- **Custom Post Type**: Easy store management with "Listo" post type
- **Location Filtering**: Country, City, District dropdown filters
- **Gutenberg Block**: Native WordPress block editor support
- **Shortcode Support**: `[listo-stores]` shortcode with parameters
- **Modular Architecture**: Expandable module system
- **WordPress Standards**: Following WordPress coding standards
- **Responsive Design**: Mobile-friendly interface

## 📦 Installation

### From GitHub
1. Download the latest release
2. Upload to `/wp-content/plugins/listo-store-locator/`
3. Activate the plugin through WordPress admin

### From WordPress Admin
1. Go to Plugins > Add New
2. Search for "Listo Store Locator"
3. Install and activate

## 🔧 Usage

### Admin Panel
1. Go to **Listo** → **Add New** to create locations
2. Fill in location details (Country, City, District, etc.)
3. Set status to Active/Inactive
4. Manage modules from **Listo** → **Modules**

### Gutenberg Block
1. Add new block in page editor
2. Search for "Listo Store Locator"
3. Configure settings in right panel
4. Publish page

### Shortcode
Use `[listo-stores]` shortcode with optional parameters:

```
[listo-stores limit="10"]
[listo-stores country="turkey" city="istanbul"]
[listo-stores limit="5" district="kadikoy"]
```

#### Shortcode Parameters
- `limit`: Number of locations to display (default: 10)
- `country`: Filter by country
- `city`: Filter by city
- `district`: Filter by district

## 🏗️ Development

### Project Structure
```
listo-store-locator/
├── admin/                  # Admin panel functionality
├── public/                 # Frontend functionality
├── shortcodes/            # Shortcode handlers
├── modules/               # Modular features
├── assets/                # Static files
└── listo-store-locator.php # Main plugin file
```

### Module System
The plugin uses a modular architecture for easy expansion:

- **Basic Module**: Core listing functionality
- **Maps Module**: Google Maps integration (coming soon)
- **Filters Module**: Advanced filtering (coming soon)
- **Routes Module**: Directions and routing (coming soon)

## 🛣️ Roadmap

### V1.0 - MVP ✅
- [x] Custom Post Type
- [x] Basic location management
- [x] Shortcode support
- [x] Gutenberg block

### V1.1 - Filtering
- [ ] Frontend location filtering
- [ ] Search functionality
- [ ] Pagination

### V2.0 - Maps
- [ ] Google Maps integration
- [ ] Location markers
- [ ] Geocoding support

### V3.0 - Advanced Features
- [ ] Route planning
- [ ] Multi-language support
- [ ] Import/Export functionality

## 🔌 Requirements

- WordPress 5.0 or higher
- PHP 7.4 or higher
- MySQL 5.6 or higher

## 🤝 Contributing

We welcome contributions! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push to the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

### Coding Standards
- Follow [WordPress Coding Standards](https://developer.wordpress.org/coding-standards/)
- Use meaningful variable and function names
- Add proper documentation
- Test thoroughly before submitting

## 📄 License

This project is licensed under the GPL v2 License - see the [LICENSE](LICENSE) file for details.

## 👥 Authors

- **Hosteva Hosting** - *Initial work* - [https://www.hosteva.com](https://www.hosteva.com)

## 🐛 Bug Reports

Found a bug? Please create an issue on [GitHub Issues](https://github.com/hosteva/listo/issues).

## 📞 Support

- Website: [https://www.hosteva.com](https://www.hosteva.com)
- Email: support@hosteva.com

## 🙏 Acknowledgments

- WordPress community for excellent documentation
- All contributors and testers
- Users providing feedback and feature requests

---

**Made with ❤️ by [Hosteva Hosting](https://www.hosteva.com)**
