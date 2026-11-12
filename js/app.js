/**
 * Manejo asíncrono del formulario para evitar recargas.
 * Arquitectura separada: El script se carga en el index.html usando 'defer'.
 */
document.addEventListener('DOMContentLoaded', () => {
    
    const formulario = document.getElementById('formularioContrato');
    
    if (formulario) {
        formulario.addEventListener('submit', async function(e) {
            e.preventDefault(); 
            
            const btn = document.getElementById('btnGenerar');
            const originalContent = btn.innerHTML;
            btn.innerHTML = "Procesando documento...";
            btn.disabled = true;

            const formData = new FormData(this);

            try {
                // Petición POST al backend en PHP
                const response = await fetch('procesar.php', {
                    method: 'POST',
                    body: formData
                });

                if (response.ok) {
                    // Gestión de Blob para forzar descarga segura del PDF sin exponer la ruta del servidor
                    const blob = await response.blob();
                    const url = window.URL.createObjectURL(blob);
                    
                    const a = document.createElement('a');
                    a.href = url;
                    
                    // Sanitización básica del lado del cliente para el nombre del archivo
                    const safeClientName = formData.get('cliente').replace(/[^a-z0-9]/gi, '_').toLowerCase();
                    a.download = `NDA_${safeClientName}.pdf`;
                    
                    document.body.appendChild(a);
                    a.click();
                    document.body.removeChild(a);
                    
                    // Liberar memoria
                    window.URL.revokeObjectURL(url);

                    document.getElementById('mensaje').style.display = 'block';
                    this.reset();
                } else {
                    alert("Error en el servicio de generación documental. Revisa los logs del servidor.");
                }
            } catch (error) {
                alert("Fallo de conexión con el endpoint.");
                console.error("Fetch API Error:", error);
            } finally {
                setTimeout(() => {
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                }, 1000);
            }
        });
    }
});
