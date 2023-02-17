function contactar(e){
  const article = { 
    ID: e
  }

  axios.post('http://localhost/backend_ecomerce/getContacto.php', article).then(function (response){
    let mensaje = 
`
*ORDEN DE COMPRA: `+e+`*
Gracias por realizar un pedido con nosotros *minimon* %0A

Tenemos esta orden nombre de : `+response.data[0].NOMBRE+` `+response.data[0].APELLIDO+` %0A
CEDULA: `+response.data[0].ID_USER+`%0A
NOTAS: En caso de ser un error ignore
  
            `

      
      window.open('https://wa.me/'+response.data[0].TELEFONO+'/?text='+mensaje, '_blank')
  })

  
  

}


function listarOrden(e,t){
  $('#listaModal').html('')
  $('#NumeroOrden').html('#'+e)
  $('#totalModal').html(t+'$')          
  const article = { 
    ID: e
  }
  
  
  axios.post('http://localhost/backend_ecomerce/getOrdenListaProductosModal.php', article).then(function (response){
    
    response.data.map(function(item){
      

      $('#listaModal').html($('#listaModal').html()+`
        <div class="alert alert-light border-2 alert-dismissible fade show" role="alert">
          <div  class="row text-center">
              
              <div class="col">
                  <span>`+item.NOMBRE+`</span>
              </div>
              <div class="col">
                  <span>`+item.ID_PRODUCT+`</span>
              </div>
              <div class="col">
                  <span>$`+item.PRECIO+`</span>
              </div>
              
              
          </div>
          
      </div>

    
    `
    )


    }
    )

    
  })
  //getOrdenListaProductosModal.php
  
}

function eliminarOrden(e){
  const article = { 
    ID: e
  }
  axios.post('http://localhost/backend_ecomerce/eliminarOrdenProducto.php', article)
 
  axios.post('http://localhost/backend_ecomerce/eliminarOrden.php', article).then(function (response){
    
      $('#tabla').html('')
     
        /*Eviamos sentencia*/
      axios.post('http://localhost/backend_ecomerce/getAllOrden.php').then(function (response){
          response.data.reverse()
          response.data.map(function(e){
            
            const id_Orden = { 
              ID:e['ID_ORDEN']
            }
            axios.post('http://localhost/backend_ecomerce/getOrdenPoducto.php', id_Orden).then(function(r){
             
              let status =''
              let color = ''
              if(e.STATUS ==1){
                status = 'Pendiente'
                color = 'bg-warning'
              }
              if(e.STATUS ==2){
                status = 'Pago'
                color = 'bg-primary'
              }
              if(e.STATUS ==3){
                status = 'Completado'
                color = 'bg-success'
              }
              
              $('#tabla').html($('#tabla').html()+`
              
              <tr>
                <th scope="row">`+e.ID_ORDEN+`</th>
                <th scope="col"><span class="border rounded `+color+` p-1  text-white orden">`+status+`</span></th> <!--3 estados (Pendiente, pagada, enviada, completada) -->
                <th scope="col">`+r.data.length+`</th>
                <th scope="col">`+e.FECHA+`</th>
                <th scope="col">`+e.TOTAL+`</th>
                <th scope="col">
                <button  type="button"  onClick="listarOrden(`+e.ID_ORDEN+` , `+e.TOTAL+`)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-eye"></i> Ver</button>
                </th>
                <th scope="col"><button onClick="eliminarOrden(`+e.ID_ORDEN+`)" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
                <th scope="col"><button type="button" onClick="contactar(`+e.ID_ORDEN+`)" class="btn bg-success text-white"><i class="fa-brands fa-whatsapp fa-lg"></i></button></th>
              </tr>
              
              
              `)
              
            })
           

          }
          )
        })

  })

  

}


let dashboard = `
<span class="h5">LISTA DE ORDENES</span>
<hr></hr>
              <table class="table table-hover text-center">
        <thead>
          <tr>
            <th scope="col">#orden</th>
            <th scope="col">Estado</th>
            <th scope="col">Productos</th>
            <th scope="col">Fecha</th>
            <th scope="col">Total</th>
            <th scope="col">lista</th>
            <th scope="col">Cancelar</th>
            <th scope="col">Contactar</th>
          </tr>
        </thead>
        <tbody id="tabla">
          
          
        </tbody>
    </table>`;

let inventario = `
<span class="h5">Inventario</span>
<hr></hr>
<table class="table table-hover text-center">
<thead>
  <tr>
    <th scope="col">#Codigo</th>
    <th scope="col">Nombre</th>
    <th scope="col">Precio</th>
    <th scope="col">cantidad</th>
    <th scope="col">Ver</th>
    <th scope="col">Eliminar</th>
  </tr>
</thead>
<tbody>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  <tr>
    <th scope="row">5555522012</th>
    <th scope="col">Termo Azul</th> 
    <th scope="col">10$</th>
    <th scope="col">20</th>
    <th scope="col"><button class="btn btn-primary"><i class="fa-solid fa-eye"></i> Ver</button></th>
    <th scope="col"><button class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
  </tr>
  
  
</tbody>
</table>`;

let producto = `
<span class="h5">Producto</span>
<hr></hr>
<form action="">
<div class="mb-3">
  <label for="formFile" class="form-label">Imagen<span class="text-danger">*</span></label>
  <input class="form-control" type="file" id="formFile">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Codigo<span class="text-danger">*</span></label>
  <input type="Number" class="form-control" id="exampleFormControlInput1" placeholder="Codigo">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Nombre<span class="text-danger">*</span></label>
  <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="Nombre">
</div>
<div class="mb-3">
  <label for="exampleFormControlInput1" class="form-label">Cantidad<span class="text-danger">*</span></label>
  <input type="Number" class="form-control" id="exampleFormControlInput1" placeholder="Cantidad">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Descripcion<span class="text-danger">*</span></label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>

  <button type="button" class="btn btn-primary">Buscar <i class="fa-solid fa-magnifying-glass"></i></button>
  <button type="button" class="btn btn-primary">Guardar <i class="fa-solid fa-floppy-disk"></i></button>
  <button type="button" class="btn btn-primary">Eliminar <i class="fa-solid fa-trash"></i></button>

</form>`;

function dashboardAdmin(){
    document.getElementById('section-principal').innerHTML = dashboard;

}
function dashboardInventario(){
    document.getElementById('section-principal').innerHTML = inventario;
}
function dashboardProducto(){
    document.getElementById('section-principal').innerHTML = producto;
}
function dashboardCerrar(){
    console.log('cerrar');
    location.href='./index.html'
}


function listaOrdenes(){
  dashboardAdmin()
  axios.post('http://localhost/backend_ecomerce/getAllOrden.php').then(function (response){
          response.data.reverse()
          response.data.map(function(e){
            
            const id_Orden = { 
              ID:e['ID_ORDEN']
            }
            axios.post('http://localhost/backend_ecomerce/getOrdenPoducto.php', id_Orden).then(function(r){
             
              let status =''
              let color = ''
              if(e.STATUS ==1){
                status = 'Pendiente'
                color = 'bg-warning'
              }
              if(e.STATUS ==2){
                status = 'Pago'
                color = 'bg-primary'
              }
              if(e.STATUS ==3){
                status = 'Completado'
                color = 'bg-success'
              }
              
              $('#tabla').html($('#tabla').html()+`
              
              <tr>
                <th scope="row">`+e.ID_ORDEN+`</th>
                <th scope="col"><span class="border rounded `+color+` p-1  text-white orden">`+status+`</span></th> <!--3 estados (Pendiente, pagada, enviada, completada) -->
                <th scope="col">`+r.data.length+`</th>
                <th scope="col">`+e.FECHA+`</th>
                <th scope="col">`+e.TOTAL+`</th>
                <th scope="col">
                <button  type="button"  onClick="listarOrden(`+e.ID_ORDEN+` , `+e.TOTAL+`)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-eye"></i> Ver</button>
                                 
                
                </th>
                <th scope="col"><button onClick="eliminarOrden(`+e.ID_ORDEN+`)" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
                <th scope="col">
                <button type="button" onClick="contactar(`+e.ID_ORDEN+`)" class="btn bg-success text-white"><i class="fa-brands fa-whatsapp fa-lg"></i></button>
                </th>
              </tr>
              
              
              `)
              
            })
           

          }
          )
        })
  }

$(document).ready(
    function (){
        dashboardAdmin()
        axios.post('http://localhost/backend_ecomerce/getAllOrden.php').then(function (response){
                response.data.reverse()
                response.data.map(function(e){
                  
                  const id_Orden = { 
                    ID:e['ID_ORDEN']
                  }
                  axios.post('http://localhost/backend_ecomerce/getOrdenPoducto.php', id_Orden).then(function(r){
                   
                    let status =''
                    let color = ''
                    if(e.STATUS ==1){
                      status = 'Pendiente'
                      color = 'bg-warning'
                    }
                    if(e.STATUS ==2){
                      status = 'Pago'
                      color = 'bg-primary'
                    }
                    if(e.STATUS ==3){
                      status = 'Completado'
                      color = 'bg-success'
                    }
                    
                    $('#tabla').html($('#tabla').html()+`
                    
                    <tr>
                      <th scope="row">`+e.ID_ORDEN+`</th>
                      <th scope="col"><span class="border rounded `+color+` p-1  text-white orden">`+status+`</span></th> <!--3 estados (Pendiente, pagada, enviada, completada) -->
                      <th scope="col">`+r.data.length+`</th>
                      <th scope="col">`+e.FECHA+`</th>
                      <th scope="col">`+e.TOTAL+`</th>
                      <th scope="col">
                      <button  type="button"  onClick="listarOrden(`+e.ID_ORDEN+` , `+e.TOTAL+`)" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><i class="fa-solid fa-eye"></i> Ver</button>
                                       
                      
                      </th>
                      <th scope="col"><button onClick="eliminarOrden(`+e.ID_ORDEN+`)" class="btn btn-danger"><i class="fa-solid fa-trash"></i></button></th>
                      <th scope="col">
                        <button type="button" onClick="contactar(`+e.ID_ORDEN+`)" class="btn bg-success text-white"><i class="fa-brands fa-whatsapp fa-lg"></i></button>
                      </th>
                    </tr>
                    
                    
                    `)
                    
                  })
                 

                }
                )
              })
        }
        )
    

