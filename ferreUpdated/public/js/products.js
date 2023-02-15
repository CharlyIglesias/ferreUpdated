
class Product {
    constructor() {
        this.id = 0;
        this.name = searchedText;
        this.description = '';
        this.imageUrl = '';
        this.inStock = true;
        this.familia = [];
        this.brand = [];
    }
}
window.onload = function () {
    var vm = new Vue({
        el: '.page-container',
        delimiters: ['${', '}'],
        data: {
            currentProduct: new Product(),
            allFamilies: familiesArr,
            allBrands: brandsArr,
            searchedText: searchedText
        },
        mounted: function () {
            new Splide( '.splide', {
                type   : 'loop',
                perPage: 3,
                perMove: 1,
                autoplay: true,
                padding: '0.1rem',
                heightRatio     : 0.12,
                cover      : true,
                breakpoints: {
                    640: {
                        perPage: 1,
                        heightRatio: 0.4
                    },
                }
            } ).mount();
            // $('#searchedText').val(this.searchedText);
            // vm.currentProduct.name = this.searchedText;
        },
        methods: {
            allFamiliesList: function(){
                return this.allFamilies.filter(x => x.name != "");
            },
            allBrandsList: function(){
                return this.allBrands.filter(x => x.name != "");
            },
            filter: function(){
                // console.log(vm.currentProduct.familia.id);
                // console.log(vm.currentProduct.brand.id);
                // console.log("tacos");

                $.get(filtrarProductosUrl, {familias: vm.currentProduct.familia, brand: vm.currentProduct.brand, name: vm.currentProduct.name} ,function(data){
                    if(data['data'] == "Tú búsqueda no arrojo ningún resultado."){
                        showToastr('warning', '¡Oops!', "Tú búsqueda no arrojo ningún resultado..");
                    }else{
                        $('#appendHere').html(data['data']);
                    }
                });
            }
        }

    });
}