
class Product {
    constructor() {
        this.id = 0;
        this.name = '';
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
            allBrands: brandsArr
        },
        mounted: function () {
            this.$nextTick(function () {
                var myWidget = cloudinary.createUploadWidget({
                    cloudName: 'dtmln7c4k', 
                    sources: [ 'local', 'url', 'image_search'],
                    googleApiKey: 'AIzaSyB7oWyNIpXwnur0A2-RkziQHiGJ6mfz9O0',
                    cropping: true,
                    background_removal: 'cloudinary_ai',
                    uploadPreset: 'mba5txfa'}, 
                    (error, result) => { 
                    if (!error && result && result.event === "success") { 
                        console.log('Done! Here is the image info: ', result.info); 
                        console.log(result.info['secure_url']);
                        vm.currentProduct.imageUrl = result.info['secure_url'];
                        $('#blah').attr('src', result.info['secure_url']);
                    }
                    },
                )
                document.getElementById("blah").addEventListener("click", function(){
                    myWidget.open();
                }, false);
            })
        },
        methods: {
            allFamiliesList: function(){
                return this.allFamilies.filter(x => x.name != "");
            },
            allBrandsList: function(){
                return this.allBrands.filter(x => x.name != "");
            },
            addTagFamily (newTag) {
                const tag = {
                  name: newTag,
                  id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.allFamilies.push(tag);
                this.currentProduct.familia.push(tag);
            },
            addTagBrand (newTag) {
                const tag = {
                  name: newTag,
                  id: newTag.substring(0, 2) + Math.floor((Math.random() * 10000000))
                }
                this.allBrands.push(tag);
                this.currentProduct.brand.push(tag);
            },
            checkSucursal(event){
                if(event.target.id == 'checkboxSucursal') {
                    $('#checkboxPedido').prop('checked', false);
                    this.currentProduct.inStock = true;
                }else{
                    this.currentProduct.inStock = false;
                    $('#checkboxSucursal').prop('checked', false);
                }
            }
        }

    });
}