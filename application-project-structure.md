# Highper Blueprint Project Structure

## Application Project Structure

```
my-microservice/
├── app/                            # Application code
│   ├── Controllers/                # Controllers
│   │   ├── Api/                    # API controllers
│   │   │   └── UserController.php  # User API controller
│   │   └── Web/                    # Web controllers
│   │       └── HomeController.php  # Home controller
│   ├── Models/                     # Models
│   │   └── UserModel.php           # User model
│   ├── Providers/                  # Service providers
│   │   └── AppServiceProvider.php  # Application service provider
│   ├── Views/                      # View templates
│   │   └── home.php                # Home page template
│   └── WebSocket/                  # WebSocket handlers
│       └── ChatHandler.php         # Chat handler
├── bin/                            # Binary executables
│   └── console                     # Console entry point
├── config/                         # Configuration files
│   ├── app.php                     # Application config
│   ├── cors.php                    # CORS config
│   ├── database.php                # Database config
│   ├── logging.php                 # Logging config
│   ├── security.php                # Security config
│   └── tracing.php                 # Tracing config
├── public/                         # Public assets
│   ├── assets/                     # Static assets
│   │   ├── css/                    # CSS files
│   │   ├── js/                     # JavaScript files
│   │   └── img/                    # Image files
│   └── index.php                   # Application entry point
├── resources/                      # Application resources
│   └── views/                      # View templates
├── routes/                         # Route definitions
│   ├── api.php                     # API routes
│   └── web.php                     # Web routes
├── storage/                        # Storage directory
│   ├── cache/                      # Cache files
│   ├── logs/                       # Log files
│   └── app/                        # Application storage
├── tests/                          # Test suite
│   ├── Unit/                       # Unit tests
│   ├── Feature/                    # Feature tests
│   └── Integration/                # Integration tests
├── vendor/                         # Composer dependencies
├── .env                            # Environment variables
├── .env.example                    # Environment example
├── composer.json                   # Composer configuration
├── docker-compose.yml              # Docker Compose config
├── Dockerfile                      # Docker configuration
├── phpunit.xml                     # PHPUnit configuration
└── README.md                       # Project documentation
```

The Highper Blueprintapplication project structure provides a starting point for building microservices with Highper framework.
