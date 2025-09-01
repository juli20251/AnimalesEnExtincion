function showSection(sectionName) {
    // Ocultar todas las secciones
    document.querySelectorAll('.section').forEach(section => {
        section.classList.remove('active');
        section.style.display = 'none'; // Asegurarse de ocultarlas
    });

    // Mostrar la sección seleccionada
    const selectedSection = document.getElementById(sectionName);
    if (selectedSection) {
        selectedSection.classList.add('active');
        selectedSection.style.display = 'block'; // Mostrar la sección seleccionada
    }

    // Actualizar tabs
    document.querySelectorAll('.nav-tab').forEach(tab => {
        tab.classList.remove('active');
    });

    // Encontrar y activar el tab correcto
    const tabs = document.querySelectorAll('.nav-tab');
    tabs.forEach(tab => {
        if (tab.getAttribute('onclick').includes(sectionName)) {
            tab.classList.add('active');
        }
    });
}

// Función para abrir un modal
function openModal(modalId) {
    document.getElementById(modalId).style.display = 'block';
}

// Función para cerrar un modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Función para calcular el total de las entradas
function updateTotal() {
    const adults = parseInt(document.getElementById('adults').value) || 0;
    const children = parseInt(document.getElementById('children').value) || 0;
    const students = parseInt(document.getElementById('students').value) || 0;
    const seniors = parseInt(document.getElementById('seniors').value) || 0;
    
    const total = (adults * 2500) + (children * 1800) + (students * 2000) + (seniors * 1500);
    document.getElementById('totalPrice').textContent = total.toLocaleString();
}

// Procesar el pago
function processPayment() {
    const name = document.getElementById('customerName').value;
    const email = document.getElementById('customerEmail').value;
    const phone = document.getElementById('customerPhone').value;
    const visitDate = document.getElementById('visitDate').value;
    const paymentMethod = document.getElementById('paymentMethod').value;
    const total = document.getElementById('totalPrice').textContent;

    if (!name || !email || !phone || !visitDate || !paymentMethod) {
        alert('Por favor completa todos los campos requeridos');
        return;
    }

    if (total === '0') {
        alert('Por favor selecciona al menos una entrada');
        return;
    }

    if (paymentMethod === 'efectivo') {
        generateTicket(name, email, phone, visitDate, total, paymentMethod);
    } else if (paymentMethod === 'tarjeta') {
        showCardForm();
    } else {
        alert('Método de pago no soportado.');
    }
}

// Guardar compras realizadas en localStorage
function savePurchaseHistory() {
    localStorage.setItem('purchaseHistory', JSON.stringify(purchaseHistory));
}

// Cargar compras realizadas desde localStorage
function loadPurchaseHistory() {
    const storedHistory = localStorage.getItem('purchaseHistory');
    if (storedHistory) {
        return JSON.parse(storedHistory);
    }
    return [];
}

// Inicializar el historial de compras
const purchaseHistory = loadPurchaseHistory();

// Generar un ticket con los datos de la compra
function generateTicket(name, email, phone, visitDate, total, paymentMethod) {
    const ticketNumber = `TICKET-${Math.floor(100000 + Math.random() * 900000)}`;
    const ticket = {
        ticketNumber,
        name,
        email,
        phone,
        visitDate,
        total,
        paymentMethod,
    };

    // Guardar en el historial de compras
    purchaseHistory.push(ticket);
    savePurchaseHistory();

    // Mostrar el ticket generado
    const ticketDetails = `
Número de Ticket: ${ticket.ticketNumber}
Nombre: ${ticket.name}
Email: ${ticket.email}
Teléfono: ${ticket.phone}
Fecha de Visita: ${ticket.visitDate}
Método de Pago: ${ticket.paymentMethod}
Total: $${ticket.total}
    `;

    document.getElementById('ticketForm').style.display = 'none';
    document.getElementById('cardForm').style.display = 'none';
    document.getElementById('ticketContainer').style.display = 'block';
    document.getElementById('ticketDetails').textContent = ticketDetails;
}

// Cancelar una compra específica
function cancelPurchase(ticketNumber) {
    const index = purchaseHistory.findIndex(purchase => purchase.ticketNumber === ticketNumber);
    if (index !== -1) {
        if (confirm(`¿Estás seguro de que deseas cancelar la compra con el ${ticketNumber}?`)) {
            purchaseHistory.splice(index, 1); // Eliminar del array
            savePurchaseHistory(); // Guardar cambios en localStorage
            showPurchaseHistory(); // Actualizar la interfaz
            alert(`La compra con el ticket ${ticketNumber} ha sido cancelada.`);
        }
    }
}

// Mostrar historial de compras en la sección de "Entradas"
function showPurchaseHistory() {
    const container = document.getElementById('purchaseHistoryContainer');
    const list = document.getElementById('purchaseHistory');
    list.innerHTML = ''; // Limpiar el historial previo

    if (purchaseHistory.length === 0) {
        list.innerHTML = '<li>No hay compras realizadas.</li>';
    } else {
        purchaseHistory.forEach((purchase) => {
            const item = document.createElement('li');
            item.style.marginBottom = '10px';
            item.style.padding = '10px';
            item.style.borderBottom = '1px solid #e0e0e0';

            const ticketInfo = document.createElement('span');
            ticketInfo.textContent = `
Ticket: ${purchase.ticketNumber} | Nombre: ${purchase.name} | Fecha: ${purchase.visitDate} | Total: $${purchase.total} | Pago: ${purchase.paymentMethod}
            `;

            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancelar compra';
            cancelButton.style.marginLeft = '10px';
            cancelButton.style.padding = '5px 10px';
            cancelButton.style.border = 'none';
            cancelButton.style.borderRadius = '5px';
            cancelButton.style.backgroundColor = '#dc3545';
            cancelButton.style.color = 'white';
            cancelButton.style.cursor = 'pointer';
            cancelButton.onclick = () => cancelPurchase(purchase.ticketNumber);

            item.appendChild(ticketInfo);
            item.appendChild(cancelButton);
            list.appendChild(item);
        });
    }

    container.style.display = 'block';
}

// Cargar el historial de compras automáticamente al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    // Verificar si estamos en la página principal (index.html)
    if (window.location.pathname.endsWith('index.html') || window.location.pathname === '/') {
        showPurchaseHistory();
    }
});

// Mostrar formulario de tarjeta
function showCardForm() {
    const paymentMethod = document.getElementById('paymentMethod').value;
    if (paymentMethod !== 'tarjeta') {
        alert('Por favor selecciona "Tarjeta de Crédito/Débito" como método de pago para continuar.');
        return;
    }

    // Validar datos del formulario principal
    const name = document.getElementById('customerName').value;
    const email = document.getElementById('customerEmail').value;
    const phone = document.getElementById('customerPhone').value;
    const visitDate = document.getElementById('visitDate').value;
    const total = document.getElementById('totalPrice').textContent;

    if (!name || !email || !phone || !visitDate || total === '0') {
        alert('Por favor completa todos los campos requeridos antes de continuar.');
        return;
    }

    // Mostrar el formulario de tarjeta
    document.getElementById('ticketForm').style.display = 'none';
    document.getElementById('cardForm').style.display = 'block';
}

// Procesar pago con tarjeta
function processCardPayment() {
    const cardNumberInput = document.getElementById('cardNumber');
    const cardExpiryInput = document.getElementById('cardExpiry');
    const cardCVVInput = document.getElementById('cardCVV');
    const cardNameInput = document.getElementById('cardName');

    // Validar que los elementos existan
    if (!cardNumberInput || !cardExpiryInput || !cardCVVInput || !cardNameInput) {
        alert('Error: No se encontraron los campos del formulario de tarjeta.');
        return;
    }

    const cardNumber = cardNumberInput.value.replace(/\s+/g, ''); // Eliminar espacios
    const cardExpiry = cardExpiryInput.value;
    const cardCVV = cardCVVInput.value;
    const cardName = cardNameInput.value;

    // Validar datos de la tarjeta
    if (!cardNumber || !cardExpiry || !cardCVV || !cardName) {
        alert('Por favor completa todos los campos de la tarjeta.');
        return;
    }

    if (cardNumber.length !== 16 || isNaN(cardNumber)) {
        alert('El número de tarjeta debe tener 16 dígitos.');
        return;
    }

    if (!/^\d{2}\/\d{2}$/.test(cardExpiry)) {
        alert('La fecha de expiración debe tener el formato MM/AA.');
        return;
    }

    if (cardCVV.length !== 3 || isNaN(cardCVV)) {
        alert('El CVV debe tener 3 dígitos.');
        return;
    }

    // Obtener datos del formulario principal
    const name = document.getElementById('customerName').value;
    const email = document.getElementById('customerEmail').value;
    const phone = document.getElementById('customerPhone').value;
    const visitDate = document.getElementById('visitDate').value;
    const total = document.getElementById('totalPrice').textContent;

    // Generar el ticket y guardar en el historial
    generateTicket(name, email, phone, visitDate, total, 'tarjeta');

    alert('Pago procesado exitosamente. ¡Gracias por tu compra!');
    document.getElementById('cardForm').reset();
    document.getElementById('reservationForm').reset();
    document.getElementById('cardForm').style.display = 'none';
    document.getElementById('ticketForm').style.display = 'block';
    updateTotal();
}

// Actualizar información de actividades
function updateActivityInfo() {
    const activityType = document.getElementById('activityType').value;
    const infoDiv = document.getElementById('activityInfo');
    const detailsDiv = document.getElementById('activityDetails');
    const timeSlot = document.getElementById('timeSlot');
    
    timeSlot.innerHTML = '<option value="">Seleccionar horario</option>';
    
    if (!activityType) {
        infoDiv.style.display = 'none';
        return;
    }
    
    infoDiv.style.display = 'block';
    
    switch(activityType) {
        case 'visita':
            detailsDiv.innerHTML = `
                <h4>🚶 Visita Guiada</h4>
                <p><strong>Duración:</strong> 90 minutos</p>
                <p><strong>Precio:</strong> $800 adicional por persona</p>
                <p><strong>Incluye:</strong> Guía especializado, acceso prioritario</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="10:00">10:00 AM</option>
                <option value="14:00">2:00 PM</option>
                <option value="16:00">4:00 PM</option>
            `;
            break;
            
        case 'feeding':
            detailsDiv.innerHTML = `
                <h4>🥕 Feeding Time</h4>
                <p><strong>Duración:</strong> 30 minutos</p>
                <p><strong>Precio:</strong> $1,200 adicional por persona</p>
                <p><strong>Incluye:</strong> Alimentación supervisada, explicación educativa</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="11:00">11:00 AM</option>
                <option value="15:00">3:00 PM</option>
            `;
            break;
            
        case 'cumpleanos':
            detailsDiv.innerHTML = `
                <h4>🎂 Cumpleaños</h4>
                <p><strong>Duración:</strong> 3 horas</p>
                <p><strong>Precio:</strong> $8,500 (hasta 15 niños)</p>
                <p><strong>Incluye:</strong> Salón privado, decoración, guía, actividades</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="10:00">10:00 AM - 1:00 PM</option>
                <option value="14:00">2:00 PM - 5:00 PM</option>
            `;
            break;
            
        case 'taller':
            detailsDiv.innerHTML = `
                <h4>🏫 Taller Educativo</h4>
                <p><strong>Duración:</strong> 60 minutos</p>
                <p><strong>Precio:</strong> $600 adicional por persona</p>
                <p><strong>Edades:</strong> 6-12 años</p>
                <p><strong>Incluye:</strong> Material educativo, certificado</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="09:00">9:00 AM</option>
                <option value="11:00">11:00 AM</option>
                <option value="14:00">2:00 PM</option>
                <option value="16:00">4:00 PM</option>
            `;
            break;
            
        case 'nocturna':
            detailsDiv.innerHTML = `
                <h4>🌙 Visita Nocturna</h4>
                <p><strong>Duración:</strong> 2 horas</p>
                <p><strong>Precio:</strong> $3,500 por persona</p>
                <p><strong>Incluye:</strong> Guía nocturno, linterna, refrigerio</p>
                <p><strong>Cupo máximo:</strong> 30 personas</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="19:30">7:30 PM - 9:30 PM</option>
                <option value="20:00">8:00 PM - 10:00 PM</option>
            `;
            break;
            
        case 'arte':
            detailsDiv.innerHTML = `
                <h4>🎨 Taller de Arte Animal</h4>
                <p><strong>Duración:</strong> 2 horas</p>
                <p><strong>Precio:</strong> $1,200 + materiales</p>
                <p><strong>Edades:</strong> 8-14 años</p>
                <p><strong>Incluye:</strong> Todos los materiales, instructor especializado</p>
            `;
            timeSlot.innerHTML = `
                <option value="">Seleccionar horario</option>
                <option value="10:00">10:00 AM - 12:00 PM</option>
                <option value="14:00">2:00 PM - 4:00 PM</option>
            `;
            break;
    }
}

// Historial de reservas
const reservationHistory = loadReservationHistory();

function loadReservationHistory() {
    const storedHistory = localStorage.getItem('reservationHistory');
    return storedHistory ? JSON.parse(storedHistory) : [];
}

function saveReservationHistory() {
    localStorage.setItem('reservationHistory', JSON.stringify(reservationHistory));
}

function showReservationHistory() {
    const container = document.getElementById('reservationHistoryContainer');
    const list = document.getElementById('reservationHistory');
    list.innerHTML = ''; // Limpiar el historial previo

    if (reservationHistory.length === 0) {
        list.innerHTML = '<li>No hay reservas realizadas.</li>';
    } else {
        reservationHistory.forEach((reservation) => {
            const item = document.createElement('li');
            item.style.marginBottom = '10px';
            item.style.padding = '10px';
            item.style.borderBottom = '1px solid #e0e0e0';

            const reservationInfo = document.createElement('span');
            reservationInfo.textContent = `
Reserva: ${reservation.id} | Evento: ${reservation.eventName} | Fecha: ${reservation.eventDate} | Total: $${reservation.total} | Pago: ${reservation.paymentMethod}
            `;

            const cancelButton = document.createElement('button');
            cancelButton.textContent = 'Cancelar reserva';
            cancelButton.style.marginLeft = '10px';
            cancelButton.style.padding = '5px 10px';
            cancelButton.style.border = 'none';
            cancelButton.style.borderRadius = '5px';
            cancelButton.style.backgroundColor = '#dc3545';
            cancelButton.style.color = 'white';
            cancelButton.style.cursor = 'pointer';
            cancelButton.onclick = () => cancelReservation(reservation.id);

            item.appendChild(reservationInfo);
            item.appendChild(cancelButton);
            list.appendChild(item);
        });
    }

    container.style.display = 'block';
}

// Mostrar el historial de reservas al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    if (document.getElementById('reservationHistoryContainer')) {
        showReservationHistory();
    }
});

// Función para buscar animales por nombre o especie
function filterAnimals() {
    const searchTerm = document.getElementById('searchInput').value.toLowerCase().trim();
    const animalItems = document.querySelectorAll('.animal-item');

    animalItems.forEach(item => {
        const name = item.getAttribute('data-name').toLowerCase().trim();
        const species = item.getAttribute('data-species').toLowerCase().trim();

        if (name.includes(searchTerm) || species.includes(searchTerm)) {
            item.style.display = 'flex';
        } else {
            item.style.display = 'none';
        }
    });
}

// Agregar el evento de búsqueda al input de animales
const searchInput = document.getElementById('searchInput');
if (searchInput) {
    searchInput.addEventListener('input', filterAnimals);
}

// Función para buscar especies por nombre
function filterSpecies() {
    const searchTerm = document.getElementById('speciesSearchInput').value.toLowerCase().trim();
    const speciesCards = document.querySelectorAll('.especie-card');

    speciesCards.forEach(card => {
        const speciesName = card.getAttribute('data-species').toLowerCase().trim();

        if (speciesName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Agregar el evento de búsqueda al input de especies
const speciesSearchInput = document.getElementById('speciesSearchInput');
if (speciesSearchInput) {
    speciesSearchInput.addEventListener('input', filterSpecies);
}

// Función para buscar áreas por nombre
function filterAreas() {
    const searchTerm = document.getElementById('areaSearchInput').value.toLowerCase().trim();
    const areaCards = document.querySelectorAll('.area-card');

    areaCards.forEach(card => {
        const areaName = card.getAttribute('data-area').toLowerCase().trim();

        if (areaName.includes(searchTerm)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Agregar el evento de búsqueda al input de áreas
const areaSearchInput = document.getElementById('areaSearchInput');
if (areaSearchInput) {
    areaSearchInput.addEventListener('input', filterAreas);
}

// Función para formatear el número de tarjeta
function formatCardNumber(input) {
    let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
    value = value.slice(0, 16); // Limitar a 16 dígitos
    value = value.replace(/(.{4})/g, '$1 '); // Insertar un espacio cada 4 dígitos
    input.value = value.trim(); // Actualizar el valor del campo
}

// Agregar el evento de formato al campo de número de tarjeta
document.addEventListener('DOMContentLoaded', () => {
    const cardNumberInput = document.getElementById('cardNumber');
    if (cardNumberInput) {
        cardNumberInput.addEventListener('input', () => formatCardNumber(cardNumberInput));
    }
});

// Función para formatear la fecha de expiración de la tarjeta
function formatCardExpiry(input) {
    let value = input.value.replace(/\D/g, ''); // Eliminar caracteres no numéricos
    if (value.length > 4) value = value.slice(0, 4); // Limitar a 4 caracteres
    if (value.length > 2) value = value.replace(/(\d{2})(\d{1,2})/, '$1/$2'); // Insertar la barra
    input.value = value; // Actualizar el valor del campo
}

// Agregar el evento de formato al campo de fecha de expiración
document.addEventListener('DOMContentLoaded', () => {
    const cardExpiryInput = document.getElementById('cardExpiry');
    if (cardExpiryInput) {
        cardExpiryInput.addEventListener('input', () => formatCardExpiry(cardExpiryInput));
    }
});

function showEventDetails(name, date, time, capacity, price) {
    document.getElementById('eventName').textContent = name;
    document.getElementById('eventDate').textContent = date;
    document.getElementById('eventTime').textContent = time;
    document.getElementById('eventCapacity').textContent = capacity;
    document.getElementById('eventPrice').textContent = price;
    document.getElementById('eventDetails').style.display = 'block';

    // Guardar los datos del evento en localStorage
    localStorage.setItem('selectedEvent', JSON.stringify({ name, date, time, capacity, price }));
}

// Función para procesar la reserva
function processReservation() {
    const eventName = document.getElementById('eventName').value;
    const eventDate = document.getElementById('eventDate').value;
    const eventTime = document.getElementById('eventTime').value;
    const eventPrice = parseFloat(document.getElementById('eventPrice').value.replace('$', ''));
    const customerName = document.getElementById('customerName').value;
    const customerEmail = document.getElementById('customerEmail').value;
    const customerPhone = document.getElementById('customerPhone').value;
    const peopleCount = parseInt(document.getElementById('peopleCount').value) || 1;
    const paymentMethod = document.getElementById('paymentMethod').value;

    // Validar campos requeridos
    if (!eventName || !eventDate || !eventTime || !customerName || !customerEmail || !customerPhone || !paymentMethod) {
        alert('Por favor completa todos los campos requeridos.');
        return;
    }

    const total = eventPrice * peopleCount;

    const reservationId = `RES-${Math.floor(100000 + Math.random() * 900000)}`;
    const reservation = {
        id: reservationId,
        eventName,
        eventDate,
        eventTime,
        total,
        paymentMethod,
        customerName,
        customerEmail,
        customerPhone,
    };

    reservationHistory.push(reservation);
    saveReservationHistory();
    showReservationHistory();

    if (paymentMethod === 'efectivo') {
        alert(`Reserva realizada con éxito. Número de reserva: ${reservationId}`);
    } else if (paymentMethod === 'tarjeta') {
        // Mostrar el formulario de tarjeta
        document.getElementById('reservationForm').style.display = 'none';
        document.getElementById('cardForm').style.display = 'block';
    }
}

function cancelReservation(id) {
    const index = reservationHistory.findIndex(reservation => reservation.id === id);
    if (index !== -1) {
        if (confirm(`¿Estás seguro de que deseas cancelar la reserva ${id}?`)) {
            reservationHistory.splice(index, 1); // Eliminar del array
            saveReservationHistory(); // Guardar cambios en localStorage
            showReservationHistory(); // Actualizar la interfaz
            alert(`La reserva ${id} ha sido cancelada.`);
        }
    }
}

// Función para alternar la visibilidad de las respuestas en las preguntas frecuentes
function toggleFAQ(element) {
    const answer = element.nextElementSibling; // Selecciona la respuesta asociada
    const toggle = element.querySelector('.faq-toggle'); // Selecciona el ícono de "+" o "-"
    
    if (answer.style.display === 'block') {
        answer.style.display = 'none'; // Oculta la respuesta
        toggle.textContent = '+'; // Cambia el ícono a "+"
    } else {
        answer.style.display = 'block'; // Muestra la respuesta
        toggle.textContent = '-'; // Cambia el ícono a "-"
    }
}