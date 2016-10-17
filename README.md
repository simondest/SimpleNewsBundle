# SimpleNewsBundle

### Config :

vertacoo_simple_news:
    domains: [domain]
    update_template: 'YourBundle:News:update.html.twig'
    
### Routing

vertacoo_simple_news:
    resource: "@VertacooSimpleNewsBundle/Resources/config/routing.yml"
    prefix:   /admin/news