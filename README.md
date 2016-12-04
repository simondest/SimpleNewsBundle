# SimpleNewsBundle v0.1.1

### Composer
	"repositories": [
        {
	        "type" : "vcs",
	        "url" : "https://github.com/simondest/SimpleNewsBundle.git"
	    }
    ]
    "simondest/simple-news-bundle" : "^0.1"

### AppKernel.php
	new Vertacoo\SimpleNewsBundle\VertacooSimpleNewsBundle(),

### Config :
	vertacoo_simple_news:
    upload_dir: "/uploads/news/"
    entity: YourBundle\Entity\YourEntity	#default: Vertacoo\SimpleNewsBundle\Entity\News
    domains: 
      domain_1: 
        form: YourBundle\Form\Type\YourFormType #default : Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType
        use_image: true
        image_max_size: "1M"	#default 1M
        image_max_width: 800	#default 800
        image_max_height: 600	#default 600
    update_template: 'HotelAdminBundle:News:update.html.twig'
    
### Routing
	vertacoo_simple_news:
	    resource: "@VertacooSimpleNewsBundle/Resources/config/routing.yml"
	    prefix:   /admin/news

### Database
	bin/console doctrine:schema:update    
use :  
    `url('vertacoo_simple_news_admin',{'domain':'domain'})`

### Twig Extension
	{{ vertacoo_news('domain','propertyName) }}
