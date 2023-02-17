
    let listaProductoCliente = []  
    function formularioPago(){
     
      
      
      $('#list-product').html(`
        <div class="container">
          <div class="mb-3">
            <label for="CI" class="form-label">Identificacion</label>
            <input type="Number" class="form-control" id="CI" placeholder="000000000">
          </div>
          <div class="mb-3">
            <label for="emailModal" class="form-label">Email</label>
            <input type="email" class="form-control" id="emailModal" placeholder="name@example.com" value=''>
          </div>
          <div class="mb-3">
            <label for="nombreModal" class="form-label">Nombre</label>
            <input type="text" class="form-control" id="nombreModal" placeholder="Nombre" value=''>
          </div>
          <div class="mb-3">
            <label for="apellidoModal" class="form-label">Apellido</label>
            <input type="text" class="form-control" id="apellidoModal" placeholder="Apellido" value=''>
          </div>
          <div class="mb-3">
            <label for="telefono" class="form-label">Telefono</label>
            <input type="Number" class="form-control" id="telefono" placeholder="+584120000000" value=''>
          </div>
          
        </div>
      
      `)
    }
    function listaParaModal(){

      $('#list-product').html('')
      listaProductoCliente.map(function(item){
        
        $('#list-product').html($('#list-product').html()+`
          <div class="alert alert-light border-2 alert-dismissible fade show" role="alert">
            <div  class="row text-center">
                
                <div class="col">
                    <span>`+item.Nombre+`</span>
                </div>
                <div class="col">
                    <span>`+item.Codigo+`</span>
                </div>
                <div class="col">
                    <span>$`+item.Precio+`</span>
                </div>
                
                <a class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="eliminar(`+item.Codigo+`,`+item.Precio+`,`+item.id+`)"></a>
            </div>
            
        </div>

      
      `
      )


      }
      )
      
    }  
        $(document).ready(function(){
            
           
           
            $("#numProduct").html('0')
            $('#totalAcumulado').html('0')
            $("#numProductModal").html('0')
            $('#totalAcumuladoModal').html('0')

            fetch('http://localhost/backend_ecomerce/getProducto.php')
            .then(res => res.json())
            .then((productos)=>{
              
              productos.map(
                
                function catalogo(e,index){
                  
                  
                    $('#catalogo').html($('#catalogo').html()+`
                        <div class="col my-2">
                            <div class="card   border-0 shadow ">
                                
                                <img src='data:image/jpg;base64,`+e.FILE+`' class="bd-placeholder-img card-img-top img-fluid " width="250"  role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false"/>
                                <div class="card-body ">
                                <p class='h5'>`+e.NOMBRE+`</p>
                                <p>$`+e.PRECIO+`</p>
                                
                                <form action="">
                                    <input type="hidden" name="id" value="`+index+`">
                                    <input type="hidden" name="nombre" value="`+e.NOMBRE+`">
                                    <input type="hidden" name="codigo" value="`+e.ID_PRODUCT+`">
                                    <input type="hidden" name="precio" value="`+e.PRECIO+`">
                                    <button style="border-radius: 0px ; padding: 0px;" class=' btn text-decoration-none text-dark fw-bolder btn-add me-1'  type="submit" value="Submit">Añadir <i class="fa-solid fa-cart-shopping"></i></button>
                                </form> 
                                </div>
                            </div>
                        </div>
                    
                    `)
                    
                }
            )

            $("form").submit(function(e){
              
              listaProductoCliente.push({
                  "id":listaProductoCliente.length,
                  "Nombre":e.target['nombre'].value,
                  "Codigo":e.target['codigo'].value,
                  "Precio":e.target['precio'].value
              
              })
            
              let dato1 = Number($('#totalAcumulado').html())
              let dato2 = Number(e.target['precio'].value)
              let num = listaProductoCliente.length-1
              
              $('#totalAcumulado').html((dato1+dato2).toFixed(2))
              $('#totalAcumuladoModal').html(Number($("#totalAcumulado").html()))
              $("#numProduct").html(Number($("#numProduct").html()) +1) 
              $("#numProductModal").html(Number($("#numProduct").html())) 
              
              
              e.preventDefault()
            
              $('#list-product').html($('#list-product').html()+`
                  <div class="alert alert-light border-2 alert-dismissible fade show" role="alert">
                      <div  class="row text-center">
                          
                          <div class="col">
                              <span>`+e.target['nombre'].value+`</span>
                          </div>
                          <div class="col">
                              <span>`+e.target['codigo'].value+`</span>
                          </div>
                          <div class="col">
                              <span>$`+e.target['precio'].value+`</span>
                          </div>
                          
                          <a class="btn-close" data-bs-dismiss="alert" aria-label="Close" onclick="eliminar(`+e.target['codigo'].value+`,`+e.target['precio'].value+`,`+num+`)"></a>
                      </div>
                      
                  </div>
              
              
              `)
          });
            }).catch(err=> console.log(err))
            

            
            
            
        });

    
        function eliminar(codigo, precio, id){
          $("#numProduct").html(Number($("#numProduct").html()) -1)
          $("#numProductModal").html(Number($("#numProduct").html()))
          
          let dato = Number($('#totalAcumulado').html())
          
          let result = dato-precio
          
          $('#totalAcumulado').html(result.toFixed(2))
          $('#totalAcumuladoModal').html($('#totalAcumulado').html())
          listaProductoCliente = listaProductoCliente.filter(item => item.id != id)
         
          

           
        }


        function sleep(ms) {
          return new Promise(resolve => setTimeout(resolve, ms));
        }