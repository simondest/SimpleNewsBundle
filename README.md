# SimpleNewsBundle

## Composer
	"repositories": [
        {
	        "type" : "vcs",
	        "url" : "https://github.com/simondest/SimpleNewsBundle.git"
	    }
    ]
    "simondest/simple-news-bundle" : "dev-master"

## AppKernel.php
    new Vertacoo\SimpleNewsBundle\VertacooSimpleNewsBundle(),
    
## Config :
### SimpleNews
Configure at least one domain with its entity and form
```yaml
vertacoo_simple_news:
    domains: 
      my_domain_1: 
      	entity: YourBundle\Entity\News
      	title: My title # it is the title which is displaying in the default admin template
        form: YourBundle\Form\Type\YourFormType 
        update_template: 'YourBundle:News:update.html.twig'
```    
## Routing
```yaml
vertacoo_simple_news:
    resource: '@VertacooSimpleNewsBundle/Controller/DefaultController.php'
    prefix:   /admin/news
    type: annotation
```	    
use :  
    `url('vertacoo_simple_news_admin',{'domain':'my_domain_1'})`
        
## Create your News entity.
Create a doctrine entity in your bundle extending Vertacoo\SimpleNewsBundle\Entity\News
If you plan to use images you must use vichUloaderBundle (the simpleNews twig extension need this to get the right path for the images)
````php
namespace YourBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Vertacoo\SimpleNewsBundle\Entity\News as BaseNews;
use Symfony\Component\HttpFoundation\File\File;


/**
 * @ORM\Entity
 * @ORM\Table(name="news")
 */
class News extends BaseNews
{
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $title;
    
    /**
     * @ORM\Column(type="text")
     */
    protected $body;
    
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
}
````	


## Create custom FormType
Create the form type that must extends Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType and add it as a service

#### FormType example :
````php
	namespace YourBundle\Form\Type;

	use Symfony\Component\Form\FormBuilderInterface;
	use Symfony\Component\Form\Extension\Core\Type\SubmitType;
	use Symfony\Component\Form\Extension\Core\Type\TextareaType;
	use Symfony\Component\Form\Extension\Core\Type\TextType;
	
	use Vertacoo\SimpleNewsBundle\Form\Type\NewsFormType as BaseType;
	
	class YourFormType extends BaseType
	{
	
	    public function buildForm(FormBuilderInterface $builder, array $options)
	    {
	        parent::buildForm($builder, $options);
	        $builder->add('title',TextType::class)
	        		->add('body',TextareaType::class);
	        		->add('save', SubmitType::class, array(
					          'label' => 'Enregistrer'
					      ));
	    }
	
	    /**
	     *
	     * {@inheritdoc}
	     *
	     */
	    public function getName()
	    {
	        return 'example_news_form';
	    }
	}
````
#### FormType service definition:
````yaml
example.your_form_type:
    class: YourBundle\Form\Type\YourFormType
    tags:
        -  { name: form.type }
    arguments: ["%vertacoo_simple_news.entity%"]
````

## Database
	bin/console doctrine:schema:update    

## Service
````php
	// In controller
	$newsManager = $this->get('vertacoo_simple_news.news_manager');
    $news = $newsManager->findOneByDomain('my_domain');
    $news = $newsManager->findByDomain('my_domain');
    $news = $newsManager->find('news_id');
    $news = $newsManager->findBy('news_id');
````   
## Twig Extension
For text properties :
	`{{ vertacoo_news('my_domain_1','propertyName','propertyType') }}`

Takes 3 arguments :
- the domain name
- the property you want to retrieve
- the type of the propoerty (text|image)


