<<<<<<< HEAD
# Tuition-Request-Listings
Tuition Request Listings - Fields: Subject, Class, Location, Contact Info
=======
# Tuition Link - Laravel Application

A comprehensive tuition platform built with Laravel that connects students with qualified tutors. The application features both Admin and Student portals with full CRUD operations, user management, and reporting systems.

## Features

### Admin Portal
- **User Management**: View and manage all users (students and tutors)
- **Post Moderation**: Approve or remove tuition posts
- **Content Moderation**: Handle reported content and users
- **Statistics Dashboard**: View platform usage statistics
- **Subject Management**: Manage categories (subjects, locations, class levels)

### Student Portal
- **Tutor Discovery**: Browse and search for tutors by subject, class level, availability, location, and rating
- **Profile Viewing**: View detailed tutor profiles and contact information
- **Post Management**: Create, edit, and manage tuition requirement posts
- **Application Management**: Review and respond to tutor applications
- **Reporting System**: Report inappropriate content or users

## Technology Stack

- **Backend**: Laravel 12.x
- **Frontend**: Blade templates with Tailwind CSS
- **Authentication**: Laravel Jetstream with Fortify
- **Database**: MySQL/PostgreSQL/SQLite
- **UI Components**: Tailwind CSS + Alpine.js

## Installation

### Prerequisites
- PHP 8.2 or higher
- Composer
- Node.js and NPM
- Database (MySQL/PostgreSQL/SQLite)

### Setup Instructions

1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd tution_link
   ```

2. **Install PHP dependencies**
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**
   ```bash
   npm install
   ```

4. **Environment setup**
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. **Configure database**
   Edit `.env` file and set your database credentials:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=tution_link
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run migrations**
   ```bash
   php artisan migrate
   ```

7. **Seed the database**
   ```bash
   php artisan db:seed
   ```

8. **Build assets**
   ```bash
   npm run build
   ```

9. **Start the development server**
   ```bash
   php artisan serve
   ```

## Default Users

After running the seeder, the following users will be created:

### Admin User
- **Email**: admin@tutionlink.com
- **Password**: password
- **Role**: Admin

### Student Users
- **Email**: student@tutionlink.com
- **Password**: password
- **Role**: Student

- **Email**: sarah@tutionlink.com
- **Password**: password
- **Role**: Student

### Tutor Users
- **Email**: tutor@tutionlink.com
- **Password**: password
- **Role**: Tutor

- **Email**: lisa@tutionlink.com
- **Password**: password
- **Role**: Tutor

## Database Structure

### Core Tables
- `users` - User accounts with roles (admin, student, tutor)
- `subjects` - Available subjects for tuition
- `tuition_posts` - Student tuition requirements
- `tuition_applications` - Tutor applications to posts
- `reports` - User/content reports for moderation

### Key Relationships
- Users can have multiple tuition posts (students)
- Users can have multiple applications (tutors)
- Posts belong to subjects and users
- Applications link tutors to posts
- Reports can target users or posts

## Routes

### Admin Routes
- `GET /admin/dashboard` - Admin dashboard
- `GET /admin/users` - Manage users
- `GET /admin/tuition-posts` - Review posts
- `GET /admin/reports` - Handle reports
- `GET /admin/subjects` - Manage subjects
- `GET /admin/statistics` - View statistics

### Student Routes
- `GET /student/dashboard` - Student dashboard
- `GET /student/browse-tutors` - Browse tutors
- `GET /student/create-post` - Create tuition post
- `GET /student/my-posts` - View own posts
- `POST /student/posts` - Store new post
- `PUT /student/posts/{post}` - Update post

## Features in Detail

### Admin Portal Features

1. **Dashboard**
   - Overview statistics
   - Recent activity feeds
   - Quick action buttons

2. **User Management**
   - View all users with pagination
   - Change user roles
   - View user details and activity

3. **Post Moderation**
   - Review pending posts
   - Approve/reject posts
   - Delete inappropriate posts

4. **Report Handling**
   - View reported content/users
   - Resolve or dismiss reports
   - Track report status

5. **Subject Management**
   - Add/edit/delete subjects
   - View subject usage statistics
   - Enable/disable subjects

6. **Statistics**
   - User growth metrics
   - Post activity charts
   - Platform usage analytics

### Student Portal Features

1. **Dashboard**
   - Personal overview
   - Recent applications
   - Quick action buttons

2. **Tutor Discovery**
   - Advanced search filters
   - Rating-based filtering
   - Location-based search
   - Subject-specific browsing

3. **Post Management**
   - Create detailed tuition posts
   - Edit existing posts
   - Track post status
   - Manage applications

4. **Application Handling**
   - Review tutor applications
   - Accept/reject applications
   - View application details

5. **Reporting System**
   - Report inappropriate users
   - Report problematic posts
   - Provide detailed descriptions

## Security Features

- **Role-based Access Control**: Admin, Student, and Tutor roles
- **Middleware Protection**: Admin routes protected by AdminMiddleware
- **Input Validation**: Comprehensive form validation
- **CSRF Protection**: All forms protected against CSRF attacks
- **SQL Injection Prevention**: Eloquent ORM with parameter binding

## Customization

### Adding New Subjects
1. Access admin panel
2. Navigate to Subjects management
3. Add new subject with description

### Modifying User Roles
1. Access admin panel
2. Navigate to Users management
3. Change user role as needed

### Customizing Class Levels
Edit the class level options in the create post form:
```php
// In resources/views/student/create-post.blade.php
<option value="Your Custom Level">Your Custom Level</option>
```

## Development

### Running Tests
```bash
php artisan test
```

### Code Style
```bash
./vendor/bin/pint
```

### Database Reset
```bash
php artisan migrate:fresh --seed
```

## Contributing

1. Fork the repository
2. Create a feature branch
3. Make your changes
4. Add tests if applicable
5. Submit a pull request

## License

This project is licensed under the MIT License.

## Support

For support, please contact the development team or create an issue in the repository.
>>>>>>> 775f49c (Initial commit)
