<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Bienvenido a Intermodular</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">

<style>
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Poppins', sans-serif;
    height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #4e73df, #1cc88a);
    overflow: hidden;
}

.content {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(15px);
    padding: 50px;
    border-radius: 20px;
    text-align: center;
    color: white;
    width: 90%;
    max-width: 600px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
    animation: fadeIn 1.2s ease-in-out;
}

h1 {
    font-size: 2.8rem;
    margin-bottom: 20px;
    font-weight: 700;
}

p {
    font-size: 1.1rem;
    margin-bottom: 15px;
    font-weight: 300;
}

.button {
    display: inline-block;
    margin-top: 20px;
    padding: 12px 30px;
    border-radius: 50px;
    background: white;
    color: #4e73df;
    font-weight: 500;
    text-decoration: none;
    transition: all 0.3s ease;
}

.button:hover {
    background: #f8f9fc;
    transform: translateY(-3px);
    box-shadow: 0 10px 20px rgba(0,0,0,0.2);
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>
</head>

<body>
<div class="content">
    <h1>🚀 ¡Bienvenido a Intermodular!</h1>
    <p>Esta es la página principal personalizada de nuestro proyecto Laravel.</p>
    <p>Explora las funcionalidades y disfruta del despliegue de nuestra aplicación.</p>
    <a href="#" class="button">Comenzar</a>
</div>
</body>
</html>
