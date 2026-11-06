# Choghadiya Muhurat Website

A complete, production-ready Choghadiya Muhurat website built with PHP + MySQL, featuring a modern responsive UI, full admin panel dashboard, SEO-friendly architecture, and AdSense-friendly structure.

## Features

### Frontend
- **SEO-Friendly URLs**: Clean, slug-based routing (no .php or query parameters)
- **Modern Responsive Design**: Built with Poppins & Montserrat fonts, gradient UI, and smooth animations
- **Homepage**: Hero section, featured articles, categories, FAQ, trust sections, statistics, newsletter, social community
- **Single Article Page**: Featured image, breadcrumb, TOC, social share, author bio, related posts, comments, sidebar widgets
- **Category & Tag Pages**: Filtered content with pagination
- **Search Functionality**: Full-text search across articles
- **Legal Pages**: About, Contact, Privacy Policy, Disclaimer, Terms & Conditions, Editorial Policy, DMCA
- **404 Error Page**: Custom error handling

### Admin Panel
- **Dashboard**: Analytics cards, views statistics, recent activity, posts overview
- **Post Management**: Add/Edit/Delete posts with CKEditor rich text editor, featured image upload, SEO meta fields
- **Category Management**: Full CRUD operations with custom slugs
- **Author Management**: User management with role-based access
- **Comment Management**: Approve, spam, trash, and bulk actions
- **Media Library**: Image upload and management system
- **Settings**: Site configuration, branding, social media, AdSense, Google Analytics integration

### Technical SEO
- **XML Sitemap**: Auto-generated sitemap at `/sitemap.php`
- **Robots.txt**: Optimized for search engines
- **Canonical URLs**: Proper canonical tag support
- **Open Graph & Twitter Cards**: Social media meta tags
- **Schema Markup**: Ready for structured data implementation

### Performance
- **Lazy Loading**: Images load on scroll
- **Browser Caching**: Configured via .htaccess
- **GZIP Compression**: Enabled for text-based files
- **Optimized Database**: Indexed queries and efficient structure

## Project Structure

```
Choghadiya/
├── admin/
│   ├── css/              # Admin panel styles
│   ├── js/               # Admin panel scripts
│   ├── images/           # Admin panel images
│   ├── includes/         # Admin includes (sidebar, header)
│   ├── categories.php    # Category management
│   ├── posts.php         # Post management
│   ├── authors.php       # Author management
│   ├── comments.php      # Comment management
│   ├── media.php         # Media library
│   ├── settings.php      # Site settings
│   ├── dashboard.php     # Admin dashboard
│   ├── login.php         # Admin login
│   ├── logout.php        # Admin logout
│   └── index.php         # Admin router
├── assets/
│   ├── css/              # Main stylesheet
│   ├── js/               # Main JavaScript
│   ├── images/           # Frontend images
│   ├── fonts/            # Custom fonts
│   └── icons/            # SVG icons
├── uploads/
│   ├── posts/            # Post images
│   ├── authors/          # Author images
│   ├── categories/       # Category images
│   └── media/            # Media library uploads
├── includes/
│   ├── header.php        # Global header
│   └── footer.php        # Global footer
├── templates/
│   ├── home.php          # Homepage
│   ├── single.php        # Single article page
│   ├── category.php      # Category page
│   ├── tag.php           # Tag page
│   ├── search.php        # Search results
│   ├── about.php         # About page
│   ├── contact.php       # Contact page
│   ├── privacy-policy.php
│   ├── disclaimer.php
│   ├── terms.php
│   ├── editorial-policy.php
│   ├── dmca.php
│   ├── sitemap.php       # HTML sitemap
│   └── 404.php          # Error page
├── config/
│   ├── database.php      # Database connection
│   └── config.php        # Site configuration
├── .htaccess             # URL rewriting and caching
├── robots.txt            # SEO robots file
├── index.php             # Main router
└── database.sql          # Database schema

```

## Installation

### Prerequisites
- PHP 7.4 or higher
- MySQL 5.7 or higher
- Apache web server with mod_rewrite enabled
- XAMPP/WAMP (for local development)

### Setup Instructions

1. **Extract/Clone the project**
   ```
   Place the Choghadiya folder in your XAMPP htdocs directory:
   C:\xampp\htdocs\Choghadiya
   ```

2. **Import Database**
   - Open phpMyAdmin (http://localhost/phpmyadmin)
   - Create a new database named `choghadiya_muhurat`
   - Import the `database.sql` file

3. **Configure Database Connection**
   - Edit `config/database.php` if needed (default: root user, no password)
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'choghadiya_muhurat');
   ```

4. **Configure Site URL**
   - Edit `config/config.php` to set your site URL
   ```php
   define('SITE_URL', 'http://localhost/Choghadiya');
   ```

5. **Access the Website**
   - Frontend: http://localhost/Choghadiya
   - Admin Panel: http://localhost/Choghadiya/admin

6. **Default Admin Login**
   - Username: `admin`
   - Password: `admin123`
   - **Important:** Change this password immediately after first login

## Admin Panel Features

### Dashboard
- Overview statistics (posts, views, comments, users)
- Recent posts and comments
- Popular posts by views

### Posts
- Add/Edit/Delete posts
- Rich text editor (CKEditor 5)
- Featured image upload
- Category and author assignment
- SEO meta fields (title, description)
- Custom URL slug
- Featured and trending flags
- Status management (draft, published, archived)

### Categories
- Full CRUD operations
- Custom slugs
- Parent category support
- Sort order
- Status management

### Authors
- User management
- Role-based access (admin, editor, author)
- Profile management
- Password management

### Comments
- Comment moderation
- Bulk actions (approve, spam, trash)
- Reply management

### Media Library
- Image upload
- Image preview
- Copy URL functionality
- Delete media

### Settings
- General settings (site name, description, keywords)
- Branding (logo, favicon)
- Social media links
- AdSense code management
- Google Analytics integration
- Discussion settings

## SEO Features

- **Clean URLs**: All pages use slug-based URLs (e.g., `/choghadiya-muhurat-today/`)
- **XML Sitemap**: Auto-generated at `/sitemap.php`
- **Robots.txt**: Optimized for search engine crawling
- **Canonical URLs**: Prevents duplicate content issues
- **Meta Tags**: Title, description, keywords for all pages
- **Open Graph**: Facebook and social media sharing
- **Twitter Cards**: Twitter sharing optimization
- **Schema Markup**: Ready for structured data

## AdSense Integration

The website is fully AdSense-friendly with:
- Clean, reader-focused design
- Balanced spacing for ad placement
- No aggressive popups or fake buttons
- Professional trust-focused layout
- Dedicated ad spaces in header, sidebar, and footer
- AdSense code management in admin settings

## Performance Optimization

- **Lazy Loading**: Images load on scroll
- **Browser Caching**: Configured via .htaccess
- **GZIP Compression**: Enabled for text files
- **Optimized Images**: Responsive image handling
- **Efficient Database**: Indexed queries
- **Minified Assets**: CSS and JS can be minified for production

## Security

- **SQL Injection Protection**: Prepared statements throughout
- **XSS Protection**: Input sanitization
- **CSRF Protection**: Ready for token implementation
- **Password Hashing**: Bcrypt for secure password storage
- **Session Management**: Secure session handling
- **File Upload Validation**: Type and size checks

## Customization

### Changing Colors
Edit CSS variables in `assets/css/style.css`:
```css
:root {
    --primary-color: #667eea;
    --secondary-color: #764ba2;
    /* ... other variables */
}
```

### Adding New Pages
1. Create template file in `templates/`
2. Add route logic in `index.php`
3. Include header and footer

### Customizing Admin
- Admin styles: `admin/css/admin.css`
- Admin scripts: `admin/js/admin.js`

## Support

For issues or questions:
- Email: admin@choghadiya.in
- Website: http://localhost/Choghadiya/contact

## License

This project is for educational and commercial use. Modify as needed for your requirements.

## Credits

- Built with PHP, MySQL, HTML5, CSS3, JavaScript
- Icons: SVG icons (customizable)
- Fonts: Poppins & Montserrat (Google Fonts)
- Rich Text Editor: CKEditor 5

## Version

Version 1.0.0 - Initial Release

---

**Note:** This is a production-ready website. Before deploying to production:
1. Change all default passwords
2. Update site URLs in config
3. Configure Google Analytics and AdSense
4. Upload real images
5. Test all functionality
6. Enable error reporting off in production
