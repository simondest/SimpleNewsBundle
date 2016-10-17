# SimpleNewsBundle

### Composer
	"repositories": [
        {
	        "type" : "vcs",
	        "url" : "https://github.com/simondest/SimpleNewsBundle.git"
	    }
    ]
    "simondest/simple-news-bundle" : "dev-master"

### AppKernel.php
	new Vertacoo\SimpleNewsBundle\VertacooSimpleNewsBundle(),

### Config :
	vertacoo_simple_news:
	    domains: [domain]
	    update_template: 'YourBundle:News:update.html.twig'
    
### Routing
	vertacoo_simple_news:
	    resource: "@VertacooSimpleNewsBundle/Resources/config/routing.yml"
	    prefix:   /admin/news
	    
use :  url('vertacoo_simple_news_admin',{'domain':'domain'})

### Twig Extension
	{{ vertacoo_news('domain') }}
