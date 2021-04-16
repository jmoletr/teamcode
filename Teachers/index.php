<?php
    //controlamos que los datos que recibimos no esten vacios
    //usamos una condicion ternaria si txtId tiene un valor, se asignara a nuestro variable txtId, el valor de txtId
    //recibido y sino asignara espacio vacio.
    $txtId=(isset($_POST['txtId']))?$_POST['txtId']:"";
    $txtName=(isset($_POST['txtName']))?$_POST['txtName']:"";
    $txtSurname=(isset($_POST['txtSurname']))?$_POST['txtSurname']:"";
    $txtTelephone=(isset($_POST['txtTelephone']))?$_POST['txtTelephone']:"";
    $txtNif=(isset($_POST['txtNif']))?$_POST['txtNif']:"";
    $txtEmail=(isset($_POST['txtEmail']))?$_POST['txtEmail']:"";

    //lo hacemos tambien con los botones, para saber que opción ha pulsado el usuario.
    $accion=(isset($_POST['accion']))?$_POST['accion']:"";


    //-----------------------------------------------------------
    //incluimos el fichero de conexion a la base de datos
    include ("../Connection/connexion.php");

    //evaluamos los valores posibles que puede tener acción (value) dependiendo de lo que pulse el usuario.
    switch($accion) {
        case "btnAgregar":
            //instrucción SQL para insertar teachers //columnas BBDD y valores
            //":" creamos referencias para poder insertar informacion para pasarle valores que hemos declarado con anterioriad
            $sentencia=$pdo->prepare("INSERT INTO teachers(name, surname, telephone, nif, email) 
            VALUES (:name, :surname, :telephone, :nif, :email)");

            //le pasamos los valores.
            $sentencia->bindParam('name', $txtName);
            $sentencia->bindParam('surname', $txtSurname);
            $sentencia->bindParam('telephone', $txtTelephone);
            $sentencia->bindParam('nif', $txtNif);
            $sentencia->bindParam('email', $txtEmail);
            //ejecutamos sentencia
            $sentencia->execute();

            echo $txtId;
            echo "Presionaste botón Agregar";
            break;
        case "btnModificar":
            //definimos sentencia SQL para modificar teachers segun el Id.
            $sentencia=$pdo->prepare("UPDATE teachers SET 
            name=:name,
            surname=:surname, 
            telephone=:telephone,
            nif=:nif, 
            email=:email WHERE
            id_teacher=:id");

            $sentencia->bindParam(':name', $txtName);
            $sentencia->bindParam(':surname', $txtSurname);
            $sentencia->bindParam(':telephone', $txtTelephone);
            $sentencia->bindParam(':nif', $txtNif);
            $sentencia->bindParam(':email', $txtEmail);
            $sentencia->bindParam(':id', $txtId);
            $sentencia->execute();

            //redireccionamos a index.php para que cuando actualicemos no se reenvie el formulario
            header('Location: index.php');
            echo $txtId;
            echo "Presionaste botón Modificar";
            break;
        case "btnEliminar":
            //definimos sentencia SQL para eliminar teachers segun el Id.
            $sentencia=$pdo->prepare("DELETE FROM teachers WHERE id_teacher=:id");
            $sentencia->bindParam(':id', $txtId);
            $sentencia->execute();

            //redireccionamos a index.php para que cuando actualicemos no se reenvie el formulario
            header('Location: index.php');
            echo $txtId;
            echo "Presionaste botón Eliminar";
            break;
        case "btnCancelar":
            echo $txtId;
            echo "Presionaste botón Cancelar";
            break;

        default:
    }
    //Sentencia para listar todos los teachers
    $sentencia=$pdo->prepare("SELECT * FROM teachers WHERE 1");
    //ejecutamos sentencia
    $sentencia->execute();
    //asiganmaos el resultado de la consulta en listaTeachers usando FECTH_ASSOC (devuelve o asocia informacion de un bbdd a un array.)
    $listaTeachers=$sentencia->fetchAll(PDO::FETCH_ASSOC);

    //print_r($listaTeachers);
?>

<!-- ---------------------------------- -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" contents="witdh=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content "ie=edge">
    <title>Teachers Form</title>
    <!-- Carga jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous"></script>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
    <!-- Bootstrap JS Bundle-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js" integrity="sha384-JEW9xMcG8R+pH31jmWH6WWP0WintQrMb4s7ZOdauHnUtxwoG2vI5DkLtS3qm9Ekf" crossorigin="anonymous"></script>
</head>

<body>
<div class="container">
    <!--ectype para recepcionar imagenes -->
    <!-- Creamos formulario y botones -->
    <form action="" method="post" ectype="multipart/form-data" class="col-md-4">
        <!-- Button trigger modal -->
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
            Agregar Registro +
        </button>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Management Teachers</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <label for="">Name:</label>
                        <input type="text" class="form-control" name="txtName" required value="<?php /*echo $txtName;*/?>"placeholder="" id="txtName" require="">
                        <br>

                        <label for="">Surname:</label>
                        <input type="text" class="form-control" name="txtSurname" required value="<?php /*echo $txtSurname;*/?>"placeholder="" id="txtSurname" require="">
                        <br>

                        <label for="">Telephone:</label>
                        <input type="text" class="form-control" name="txtTelephone" required value="<?php /*echo $txtTelephone;*/?>"placeholder="" id="txtTelephone" require="">
                        <br>

                        <label for="">Nif:</label>
                        <input type="text" class="form-control" name="txtNif" required value="<?php /*echo $txtNif;*/?>"placeholder="" id="txtNif" require="">
                        <br>

                        <label for="">Email:</label>
                        <input type="email" class="form-control" name="txtEmail" required value="<?php /*echo $txtEmail;*/?>"placeholder="" id="txtEmail" require="">
                        <br>

                    </div>
                    <div class="modal-footer">
                        <button value="btnAgregar"  class="btn btn-success" type="submit" name="accion">Agregar</button>
                        <button value="btnModificar" class="btn btn-warning" type="submit" name="accion">Modificar</button>
                        <button value="btnEliminar" class="btn btn-danger" type="submit" name="accion">Eliminar</button>
                        <button value="btnCancelar" class="btn btn-primary" type="submit" name="accion">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
    <!--creamos tabla para mostar la información de la base de datos -->
<div class="row-cols-auto">
        <table class="table">
            <thead>
                <tr class="table table-light">
                    <!-- creamos los encabezados de las columnas. -->
                    <th>Id</th>
                    <th>Name</th>
                    <th>Surname</th>
                    <th>Telephone</th>
                    <th>Nif</th>
                    <th>Email</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <!-- usamos foreach para recorrer listaTeachers -->
            <?php foreach($listaTeachers as $teacher){ ?>
                <tr class="table table-striped">
                    <!-- mostramos cada valor de la tabla de la bbdd en cada columna de cada fila de la tabla donde
                    mostramos los datos de cada teacher. -->
                    <td><?php echo $teacher['id_teacher']; ?></td>
                    <td><?php echo $teacher['name']; ?></td>
                    <td><?php echo $teacher['surname']; ?></td>
                    <td><?php echo $teacher['telephone']; ?></td>
                    <td><?php echo $teacher['nif']; ?></td>
                    <td><?php echo $teacher['email']; ?></td>
                    <td>
                        <!-- enviamos la información de este formulario al primero
                        estos imputs es la información que esta deplegada en el forEach -->
                        <form action="" method="post">
                            <input type="hidden" name="txtId" value="<?php echo $teacher['id_teacher']; ?>">
                            <input type="hidden" name="txtName" value="<?php echo $teacher['name']; ?>">
                            <input type="hidden" name="txtSurname" value="<?php echo $teacher['surname']; ?>">
                            <input type="hidden" name="txtTelephone" value="<?php echo $teacher['telephone']; ?>">
                            <input type="hidden" name="txtNif" value="<?php echo $teacher['nif']; ?>">
                            <input type="hidden" name="txtEmail" value="<?php echo $teacher['email']; ?>">
                            <!--añadimos botón representa las acciones de cada registro -->
                            <input type="submit" value="Seleccionar" name="accion">
                            <button value="btnEliminar" type="submit" name="accion">Eliminar</button>
                        </form>
                    </td>
                </tr>
            <?php }?>
        </table>
</div>

</body>
</html>
