<?php
// src/Controller/MainController.php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

//Services
use App\Service\ProductService;

//Forms
use App\Form\CreateProductForm;

class ProductsController extends AbstractController
{
    /**
     * @Route("/productos", name="_products")
     */
    public function productsIndex(ProductService $productService)
    {
        $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $parts = parse_url($actual_link);
        $searchedText = null;
        if(array_key_exists('query',$parts)){
            parse_str($parts['query'], $query);
            $lastProducts = $productService->filterProducts(null, null, $query['search']);
            $searchedText = $query['search'];
        }else{
            $lastProducts = $productService->getLastProduct(20);
        }
        $families = $productService->getAllFamilies();
        $brands = $productService->getAllBrands();

        return $this->render('products.html.twig',[
            'products' => $lastProducts,
            'isMobile' => $this->isMobile(),
            'families' => $families,
            'brands'   => $brands,
            'searchedText' => $searchedText
        ]);
    }

    public function isMobile() {
        return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
    }

    /**
     * @Route("/crearProducto", name="_crear_producto")
     */
    public function crearProducto(ProductService $productService, Request $request)
    {
        $families = $productService->getAllFamilies();
        $brands = $productService->getAllBrands();

        $form = $this->createForm(CreateProductForm::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $id = $form->get('id')->getData(); 
            $formData = $form->getData();
            $familiesData = explode(',', $form->get("familiaId")->getData());
            $brandsData = explode(',', $form->get("marcaId")->getData());
            $familiesDataName = explode(',', $form->get("familiaName")->getData());
            $brandsDataName = explode(',', $form->get("marcaName")->getData());
            
            ($id > 0) ? $product = $productService->editProduct($id, $formData) : $product = $productService->createProduct($formData);
            $productService->addFamiliesToProduct($product,$familiesData, $familiesDataName);
            $productService->addBrandsToProduct($product, $brandsData, $brandsDataName);
            return $this->redirectToRoute('_crear_producto');
        }
        return $this->render('crear_producto.html.twig',[
            'families' => $families,
            'brands' => $brands,
            "form" => $form->createView(),
        ]);
    }

     /**
     * @Route("/viewProduct/{idProduct}", name="_ver_producto")
     */
    public function verProducto(ProductService $productService, Request $request, $idProduct = 0)
    {
        if($idProduct == 0){
            return $this->redirectToRoute('_products');
        }else{
            $product = $productService->getProductById($idProduct);
            if($product != null && !empty($product)){
                $description = $productService->getDescriptionInArray($product);
                return $this->render('view_product.html.twig',[
                    'product' => $product,
                    'descriptions' => $description
                ]);
            }else{
                return $this->redirectToRoute('_products');
            }
        }
    }

    /**
     * @Route("/filtrarProductos", name="_filtrar_productos")
     */
    public function filtrarProductos(Request $request, ProductService $productService)
    {
        $familias = $request->query->get("familias");
        $brandId = $request->query->get("brand");
        $name = $request->query->get("name");

        $resultados = $productService->filterProducts($familias, $brandId, $name);

        if(!empty($resultados)){
            $response = $this->renderView('product_list_template.html.twig', [
                'products' => $resultados,
                'isMobile' => $this->isMobile()
            ]);
            return $this->json(["data" => $response]);
        }else{
            return $this->json(["data" => 'Tú búsqueda no arrojo ningún resultado.']);
        }
        
    }

    /**
     * @Route("/ajustarDescriptions", name="_ajustar_descriptions")
     */
    public function ajustarDescriptions(Request $request, ProductService $productService)
    {
        $products = $productService->getAllProducts();
        $productService->changeDescription($products);
        return $this->json(["data" => true]);
    }
}