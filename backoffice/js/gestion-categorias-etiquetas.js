document.addEventListener('DOMContentLoaded', function () {
    const categoriaSelect = document.getElementById('categoria-select');
    const descripcionCategoria = document.getElementById('descripcion-categoria');

    const descripciones = {
        electronica: "En nuestra sección de Electrónica, ofrecemos una amplia gama de productos que incluyen teléfonos inteligentes, tabletas, computadoras, cámaras y accesorios electrónicos. Aquí encontrarás las últimas innovaciones tecnológicas y equipos de alta calidad para satisfacer todas tus necesidades tecnológicas.",
        ropa: "Nuestra colección de ropa incluye una amplia selección de prendas para hombres, mujeres y niños. Desde moda casual hasta ropa de oficina, nuestra oferta abarca todos los estilos y tendencias. Encuentra todo, desde camisas y pantalones hasta chaquetas y accesorios, para mantenerte a la moda durante todo el año.",
        hogar: "La sección de Hogar ofrece todo lo que necesitas para hacer de tu casa un lugar más acogedor. Explora nuestra selección de muebles, decoración, utensilios de cocina y mucho más. Con productos diseñados para mejorar la funcionalidad y el estilo de tu hogar, seguro encontrarás lo que buscas para cada rincón de tu casa.",
        deportes: "En la sección de Deportes, encontrarás una amplia gama de equipos y accesorios para tus actividades deportivas favoritas. Desde ropa deportiva y calzado especializado hasta equipos de entrenamiento y accesorios, tenemos todo lo necesario para ayudarte a alcanzar tus metas de fitness y disfrutar de tus deportes preferidos.",
        juguetes: "Nuestra sección de Juguetes ofrece una variada gama de productos para niños de todas las edades. Desde juguetes educativos hasta figuras de acción y juegos de construcción, aquí encontrarás todo lo necesario para estimular la creatividad y el aprendizaje de los más pequeños.",
        salud: "En la sección de Salud, encontrarás productos para el bienestar y cuidado personal, incluyendo suplementos, vitaminas, productos para el cuidado de la piel y el cabello, y equipo médico básico. Todo lo que necesitas para mantenerte saludable y sentirte bien.",
        automovil: "Nuestra oferta de Automóvil incluye una amplia gama de productos para tu vehículo, desde repuestos y accesorios hasta productos de mantenimiento y limpieza. Asegúrate de que tu coche esté en perfectas condiciones con nuestra selección de productos de calidad.",
        oficina: "En la sección de Oficina, ofrecemos una variedad de suministros y equipos para el entorno laboral. Desde mobiliario y equipo de computación hasta papelería y organizadores, aquí encontrarás todo lo necesario para equipar tu oficina y mantenerla funcionando de manera eficiente.",
        jardineria: "La sección de Jardinería proporciona todo lo necesario para cuidar y embellecer tu jardín. Explora nuestra selección de herramientas de jardinería, plantas, semillas, macetas y productos para el cuidado de tu jardín, desde el mantenimiento básico hasta la decoración.",
        libros: "Nuestra selección de Libros incluye una amplia variedad de géneros y temas, desde novelas y literatura clásica hasta libros de autoayuda y no ficción. Encuentra tu próximo libro favorito y disfruta de una lectura enriquecedora y entretenida."
    };

    categoriaSelect.addEventListener('change', function () {
        const categoria = categoriaSelect.value;
        if (categoria) {
            descripcionCategoria.value = descripciones[categoria];
        } else {
            descripcionCategoria.value = "Selecciona una categoría para ver su descripción.";
        }
    });
});
