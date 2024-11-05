let textusuario = document.getElementById('usuario');
textusuario.addEventListener("blur", function(){
    existeUsuario(textusuario.value)
}, false)

let textemail = document.getElementById('email');
textemail.addEventListener("blur", function(){
    existeEmail(textemail.value)
}, false)

function existeUsuario(usuario) {
    let url = "../../model/clases/clienteAjax.php";
    let formData = new FormData();
    formData.append("action", "existeUsuario");
    formData.append("usuario", usuario);

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
    .then(data => {
        if (data.ok) {
            document.getElementById('usuario').value = '';
            document.getElementById('validaUsuario').innerHTML  = 'Usuario no disponible';
            
        }else {
            document.getElementById('validaUsuario').innerHTML  = '';
        }
    })
}

function existeEmail(email) {
    let url = "../../model/clases/clienteAjax.php";
    let formData = new FormData();
    formData.append("action", "existeEmail");
    formData.append("email", email);

    fetch(url, {
        method: 'POST',
        body: formData
    }).then(response => response.json())
    .then(data => {
        if (data.ok) {
            document.getElementById('email').value = '';
            document.getElementById('validaEmail').innerHTML  = 'Email no disponible';
            
        }else {
            document.getElementById('validaEmail').innerHTML  = '';
        }
    })
}

