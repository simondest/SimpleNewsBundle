# SimpleNewsBundle v0.1.1

## Composer
	"repositories": [
        {
	        "type" : "vcs",
	        "url" : "https://github.com/simondest/SimpleNewsBundle.git"
	    }
    ]
    "simondest/simple-news-bundle" : "^0.1"

## AppKernel.php
	new Vich\UploaderBundle\VichUploaderBundle(),
    new Knp\DoctrineBehaviors\Bundle\DoctrineBehaviorsBundle(),
    new A2lix\TranslationFormBundle\A2lixTranslationFormBundle(),
    new Vertacoo\SimpleNewsBundle\VertacooSimpleNewsBundle(),
    
## Create your News entity

	namespace YourBundle\Entity;

	use Doctrine\ORM\Mapping as ORM;
	use Vertacoo\SimpleNewsBundle\Entity\News as BaseNews;
	use Knp\DoctrineBehaviors\Model as ORMBehaviors;
	
	
	/**
	 * @ORM\Entity
	 * @ORM\Table(name="contact")
	 */
	class News extends BaseNews
	{
	    use ORMBehaviors\Translatable\Translatable;
	    
	    /**
	     * @var int
	     *
	     * @ORM\Column(name="id", type="integer")
	     * @ORM\Id
	     * @ORM\GeneratedValue(strategy="AUTO")
	     */
	    protected $id;
	}
	
## Create your NewsTranslation entity	

	namespace YourBundle\Entity;
	
	use Doctrine\ORM\Mapping as ORM;
	use Knp\DoctrineBehaviors\Model as ORMBehaviors;
	
	
	/**
	 * @ORM\Entity
	 */
	class NewsTranslation
	{
	    use ORMBehaviors\Translatable\Translation;
	    
	    /**
	     * @ORM\Column(type="string", length=255)
	     */
	    protected $title;
	    
	    /**
	     * @ORM\Column(type="text")
	     */
	    protected $body;
	    
	    /**
	     * @ORM\Column(type="string", length=255)
	     */
	    protected $link;
	    
	    public function getTitle()
	    {
	        return $this->title;
	    }
	    
	    public function setTitle($title)
	    {
	        $this->title = $title;
	        return $this;
	    }
	    
	    public function getBody()
	    {
	        return $this->body;
	    }
	    
	    public function setBody($body)
	    {
	        $this->body = $body;
	        return $this;
	    }
	}

## Config :
### SimpleNews
	vertacoo_simple_news:
    entity: YourBundle\Entity\YourEntity
    domains: 
      my_domain_1: 
        form: YourBundle\Form\Type\YourFormType #default : Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType
        use_image: true
        image_max_size: "1M"	#default 1M
        image_max_width: 800	#default 800
        image_max_height: 600	#default 600
    update_template: 'HotelAdminBundle:News:update.html.twig'

### Vichuploader    
Vichuploadr config:
	vich_uploader:
	    db_driver: orm
	    mappings:
	        news_image:
	            uri_prefix:         /uploads/news
	            upload_destination: '%kernel.root_dir%/../web/uploads/news'
	            inject_on_load:     false
	            delete_on_update:   true
	            delete_on_remove:   true

### Translations            
Translations :

	knp_doctrine_behaviors:
	    translatable: true
	  
	a2lix_translation_form:
	    locale_provider: default       
	    locales: [en]      
	    default_locale: en             
	    required_locales: []         
	    manager_registry: doctrine     
	    templating: "A2lixTranslationFormBundle::default.html.twig"
    
## Routing
	vertacoo_simple_news:
	    resource: "@VertacooSimpleNewsBundle/Resources/config/routing.yml"
	    prefix:   /admin/news
use :  
    `url('vertacoo_simple_news_admin',{'domain':'my_domain_1'})`
## Database
	bin/console doctrine:schema:update    


### Twig Extension
	{{ vertacoo_news('my_domain_1','propertyName) }}
