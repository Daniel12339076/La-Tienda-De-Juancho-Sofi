<?php
// Archivo de prueba para diagnosticar la conexión
echo "<h2>Diagnóstico de Conexión - mi_basededatos</h2>";

// Paso 1: Probar conexión básica
echo "<h3>1. Probando conexión básica a MySQL:</h3>";
$host = "localhost";
$usuario = "root";
$clave = "";

$conn_test = new mysqli($host, $usuario, $clave);
if ($conn_test->connect_error) {
    echo "❌ Error de conexión a MySQL: " . $conn_test->connect_error . "<br>";
    die();
} else {
    echo "✅ Conexión a MySQL exitosa<br>";
}

// Paso 2: Verificar si existe la base de datos
echo "<h3>2. Verificando base de datos 'mi_basededatos':</h3>";
$result = $conn_test->query("SHOW DATABASES LIKE 'mi_basededatos'");
if ($result->num_rows == 0) {
    echo "❌ La base de datos 'mi_basededatos' NO existe<br>";
    echo "📝 Creando base de datos...<br>";
    if ($conn_test->query("CREATE DATABASE mi_basededatos")) {
        echo "✅ Base de datos 'mi_basededatos' creada exitosamente<br>";
    } else {
        echo "❌ Error al crear la base de datos: " . $conn_test->error . "<br>";
    }
} else {
    echo "✅ La base de datos 'mi_basededatos' existe<br>";
}

// Paso 3: Conectar a la base de datos específica
echo "<h3>3. Conectando a mi_basededatos:</h3>";
$conn_db = new mysqli($host, $usuario, $clave, "mi_basededatos");
if ($conn_db->connect_error) {
    echo "❌ Error al conectar a mi_basededatos: " . $conn_db->connect_error . "<br>";
    die();
} else {
    echo "✅ Conexión a mi_basededatos exitosa<br>";
}

// Paso 4: Verificar tablas
echo "<h3>4. Verificando tablas:</h3>";
$tablas = ['categorias', 'productos'];
foreach ($tablas as $tabla) {
    $result = $conn_db->query("SHOW TABLES LIKE '$tabla'");
    if ($result->num_rows == 0) {
        echo "❌ La tabla '$tabla' NO existe<br>";
    } else {
        echo "✅ La tabla '$tabla' existe<br>";
        // Contar registros
        $count_result = $conn_db->query("SELECT COUNT(*) as total FROM $tabla");
        $count = $count_result->fetch_assoc()['total'];
        echo "&nbsp;&nbsp;&nbsp;📊 Registros en $tabla: $count<br>";
    }
}

// Paso 5: Probar la clase Conexion
echo "<h3>5. Probando clase Conexion:</h3>";
try {
    require_once 'config/conexion.php';
    $conexion = new Conexion();
    $conn = $conexion->obtenerConexion();
    echo "✅ Clase Conexion funciona correctamente<br>";
    
    // Probar consulta de productos
    $result = $conn->query("SELECT COUNT(*) as total FROM productos");
    if ($result) {
        $total = $result->fetch_assoc()['total'];
        echo "✅ Consulta a productos exitosa. Total: $total productos<br>";
    } else {
        echo "❌ Error en consulta a productos: " . $conn->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error en clase Conexion: " . $e->getMessage() . "<br>";
}

// Paso 6: Probar ProductoModel
echo "<h3>6. Probando ProductoModel:</h3>";
try {
    require_once 'modelos/ProductoModel.php';
    $productoModel = new ProductoModel();
    $productos = $productoModel->obtenerTodos();
    echo "✅ ProductoModel funciona. Productos obtenidos: " . count($productos) . "<br>";
} catch (Exception $e) {
    echo "❌ Error en ProductoModel: " . $e->getMessage() . "<br>";
}

echo "<h3>7. Información del servidor:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "MySQL Version: " . $conn_db->server_info . "<br>";
echo "Directorio actual: " . getcwd() . "<br>";

$conn_test->close();
$conn_db->close();
// Archivo de prueba específico para categorías
echo "<h2>Prueba de Categorías</h2>";

// Probar conexión directa
echo "<h3>1. Probando conexión directa:</h3>";
try {
    require_once 'config/conexion.php';
    $conexion = new Conexion();
    $conn = $conexion->obtenerConexion();
    echo "✅ Conexión exitosa<br>";
    
    // Probar consulta directa a categorías
    $result = $conn->query("SELECT * FROM categorias LIMIT 5");
    if ($result) {
        echo "✅ Consulta a categorías exitosa<br>";
        echo "📊 Categorías encontradas:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "&nbsp;&nbsp;- " . $row['nombre'] . "<br>";
        }
    } else {
        echo "❌ Error en consulta: " . $conn->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Probar CategoriaModel
echo "<h3>2. Probando CategoriaModel:</h3>";
try {
    require_once 'modelos/CategoriaModel.php';
    $categoriaModel = new CategoriaModel();
    $categorias = $categoriaModel->obtenerTodos();
    echo "✅ CategoriaModel funciona. Categorías: " . count($categorias) . "<br>";
    
    foreach ($categorias as $categoria) {
        echo "&nbsp;&nbsp;- " . $categoria['nombre'] . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error en CategoriaModel: " . $e->getMessage() . "<br>";
}

// Probar CategoriaController
echo "<h3>3. Probando CategoriaController:</h3>";
try {
    // Simular una petición GET
    $_GET['accion'] = 'obtener';
    
    ob_start();
    require_once 'controladores/CategoriaController.php';
    $output = ob_get_clean();
    
    echo "✅ CategoriaController ejecutado<br>";
    echo "📄 Respuesta: " . htmlspecialchars($output) . "<br>";
    
} catch (Exception $e) {
    echo "❌ Error en CategoriaController: " . $e->getMessage() . "<br>";
}
 
// Finalizar
// Archivo de prueba específico para categorías con depuración detallada
echo "<h2>Prueba de Categorías (Depuración)</h2>";

// Paso 1: Probar conexión directa
echo "<h3>1. Probando conexión directa:</h3>";
try {
    require_once 'config/conexion.php';
    $conexion = new Conexion();
    $conn = $conexion->obtenerConexion();
    echo "✅ Conexión exitosa<br>";
    
    // Probar consulta directa a categorías
    $result = $conn->query("SELECT * FROM categorias LIMIT 5");
    if ($result) {
        echo "✅ Consulta a categorías exitosa<br>";
        echo "📊 Categorías encontradas:<br>";
        while ($row = $result->fetch_assoc()) {
            echo "&nbsp;&nbsp;- " . $row['nombre'] . "<br>";
        }
    } else {
        echo "❌ Error en consulta: " . $conn->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

// Paso 2: Inspeccionar el archivo CategoriaModel.php
echo "<h3>2. Inspeccionando CategoriaModel.php:</h3>";
$modelPath = 'modelos/CategoriaModel.php';
if (file_exists($modelPath)) {
    echo "✅ El archivo existe<br>";
    $content = file_get_contents($modelPath);
    
    // Verificar si contiene el método obtenerTodos
    if (strpos($content, 'function obtenerTodos') !== false) {
        echo "✅ El método obtenerTodos() está definido en el archivo<br>";
        
        // Verificar si hay errores de sintaxis
        echo "📝 Analizando posibles errores de sintaxis...<br>";
        
        // Crear un archivo temporal para verificar la sintaxis
        $tempFile = 'temp_check.php';
        file_put_contents($tempFile, $content);
        
        $output = [];
        exec("php -l $tempFile 2>&1", $output, $return_var);
        unlink($tempFile);
        
        if ($return_var === 0) {
            echo "✅ No hay errores de sintaxis<br>";
        } else {
            echo "❌ Error de sintaxis: " . implode("<br>", $output) . "<br>";
        }
    } else {
        echo "❌ El método obtenerTodos() NO está definido en el archivo<br>";
        echo "📝 Métodos encontrados:<br>";
        preg_match_all('/function\s+(\w+)\s*\(/', $content, $matches);
        if (!empty($matches[1])) {
            foreach ($matches[1] as $method) {
                echo "&nbsp;&nbsp;- " . $method . "()<br>";
            }
        } else {
            echo "&nbsp;&nbsp;No se encontraron métodos definidos<br>";
        }
    }
} else {
    echo "❌ El archivo NO existe en la ruta: $modelPath<br>";
}

// Paso 3: Probar CategoriaModel con manejo de errores detallado
echo "<h3>3. Probando CategoriaModel con depuración:</h3>";
try {
    echo "📝 Intentando incluir el archivo...<br>";
    require_once 'modelos/CategoriaModel.php';
    echo "✅ Archivo incluido correctamente<br>";
    
    echo "📝 Intentando crear instancia de CategoriaModel...<br>";
    $categoriaModel = new CategoriaModel();
    echo "✅ Instancia creada correctamente<br>";
    
    echo "📝 Intentando llamar al método obtenerTodos()...<br>";
    $categorias = $categoriaModel->obtenerTodos();
    echo "✅ Método ejecutado correctamente<br>";
    
    echo "📊 Categorías obtenidas: " . count($categorias) . "<br>";
    foreach ($categorias as $categoria) {
        echo "&nbsp;&nbsp;- " . $categoria['nombre'] . "<br>";
    }
} catch (Error $e) {
    echo "❌ Error PHP: " . $e->getMessage() . "<br>";
    echo "🔍 Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "<br>";
    echo "🔍 Traza:<br><pre>" . $e->getTraceAsString() . "</pre><br>";
} catch (Exception $e) {
    echo "❌ Excepción: " . $e->getMessage() . "<br>";
    echo "🔍 Archivo: " . $e->getFile() . " en línea " . $e->getLine() . "<br>";
    echo "🔍 Traza:<br><pre>" . $e->getTraceAsString() . "</pre><br>";
}

// Paso 4: Verificar la estructura de la tabla categorias
echo "<h3>4. Verificando estructura de la tabla categorias:</h3>";
try {
    $result = $conn->query("DESCRIBE categorias");
    if ($result) {
        echo "✅ Estructura de la tabla categorias:<br>";
        echo "<table border='1' style='border-collapse: collapse; margin-top: 10px;'>";
        echo "<tr><th>Campo</th><th>Tipo</th><th>Nulo</th><th>Clave</th><th>Predeterminado</th></tr>";
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['Field'] . "</td>";
            echo "<td>" . $row['Type'] . "</td>";
            echo "<td>" . $row['Null'] . "</td>";
            echo "<td>" . $row['Key'] . "</td>";
            echo "<td>" . $row['Default'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "❌ Error al obtener estructura: " . $conn->error . "<br>";
    }
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "<br>";
}

echo "<h3>5. Información del sistema:</h3>";
echo "PHP Version: " . phpversion() . "<br>";
echo "Directorio actual: " . getcwd() . "<br>";
echo "Ruta completa del script: " . __FILE__ . "<br>";
?>
