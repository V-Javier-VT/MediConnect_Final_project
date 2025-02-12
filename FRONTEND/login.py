import streamlit as st
import requests

# Configuración de la página de Streamlit
st.set_page_config(page_title="Sistema de Gestión Médica", page_icon="🏥")

st.title("🏥 Sistema de Gestión Médica")

# Inicializar variables en sesión si no existen
if "token" not in st.session_state:
    st.session_state.token = None
if "authenticated" not in st.session_state:
    st.session_state.authenticated = False
if "page" not in st.session_state:
    st.session_state.page = "login"

# Función de Login
def login_page():
    st.subheader("🔐 Iniciar Sesión")
    email = st.text_input("Correo Electrónico", placeholder="Ingrese su correo electrónico")
    password = st.text_input("Contraseña", type="password", placeholder="Ingrese su contraseña", key="password")

    if st.button("Iniciar sesión"):
        if email and password:
            url = "http://localhost:1001/auth/login"
            data = {"email": email, "password": password}
            
            try:
                response = requests.post(url, json=data)
                if response.status_code == 200:
                    response_data = response.json()
                    st.success("Inicio de sesión exitoso")

                    # Guardar token y estado de autenticación
                    st.session_state.token = response_data.get("token")
                    st.session_state.authenticated = True
                    st.session_state.page = "dashboard"
                    st.rerun()
                else:
                    st.error(f"Error: {response.status_code} - {response.text}")
            except requests.exceptions.RequestException as e:
                st.error(f"Error de conexión: {e}")
        else:
            st.warning("Por favor, ingrese correo electrónico y contraseña")

# Función para mostrar opciones después del login
def dashboard():
    st.subheader("📋 Panel de Administración")

    st.write("Seleccione una opción:")

    col1, col2, col3 = st.columns(3)

    with col1:
        if st.button("➕ Crear Paciente"):
            st.session_state.page = "create_patient"
            st.rerun()

    with col2:
        if st.button("👨‍⚕️ Crear Doctor"):
            st.session_state.page = "create_doctor"
            st.rerun()

    with col3:
        if st.button("📅 Crear Cita"):
            st.session_state.page = "create_appointment"
            st.rerun()

    if st.button("Cerrar Sesión"):
        st.session_state.token = None
        st.session_state.authenticated = False
        st.session_state.page = "login"
        st.rerun()

# Función para crear pacientes
def create_patient():
    st.subheader("➕ Crear Paciente")
    name = st.text_input("Nombre Completo")
    age = st.number_input("Edad", min_value=0)
    gender = st.selectbox("Género", ["Masculino", "Femenino", "Otro"])
    email = st.text_input("Correo Electrónico")

    if st.button("Guardar Paciente"):
        url = "http://localhost:3005/api/patients"
        headers = {"Authorization": f"Bearer {st.session_state.token}"}
        data = {"name": name, "age": age, "gender": gender, "email": email}

        response = requests.post(url, json=data, headers=headers)
        if response.status_code == 201:
            st.success("Paciente creado exitosamente")
        else:
            st.error(f"Error al crear paciente: {response.text}")

# Función para crear doctores
def create_doctor():
    st.subheader("👨‍⚕️ Crear Doctor")
    name = st.text_input("Nombre Completo")
    specialty = st.text_input("Especialidad")
    email = st.text_input("Correo Electrónico")

    if st.button("Guardar Doctor"):
        url = "http://localhost:4001/api/doctors"
        headers = {"Authorization": f"Bearer {st.session_state.token}"}
        data = {"name": name, "specialty": specialty, "email": email}

        response = requests.post(url, json=data, headers=headers)
        if response.status_code == 201:
            st.success("Doctor creado exitosamente")
        else:
            st.error(f"Error al crear doctor: {response.text}")

# Función para crear citas
def create_appointment():
    st.subheader("📅 Crear Cita")
    doctor_id = st.number_input("ID del Doctor", min_value=1)
    patient_id = st.number_input("ID del Paciente", min_value=1)
    appointment_date = st.date_input("Fecha de la Cita")
    status = st.selectbox("Estado", ["Pendiente", "Confirmado", "Cancelado"])

    if st.button("Guardar Cita"):
        url = "http://localhost:5001/api/appointments"
        headers = {"Authorization": f"Bearer {st.session_state.token}"}
        data = {
            "doctor_id": doctor_id,
            "patient_id": patient_id,
            "appointment_date": str(appointment_date),
            "status": status
        }

        response = requests.post(url, json=data, headers=headers)
        if response.status_code == 201:
            st.success("Cita creada exitosamente")
        else:
            st.error(f"Error al crear cita: {response.text}")

# Manejo de Navegación
if st.session_state.page == "login":
    login_page()
elif st.session_state.page == "dashboard":
    dashboard()
elif st.session_state.page == "create_patient":
    create_patient()
elif st.session_state.page == "create_doctor":
    create_doctor()
elif st.session_state.page == "create_appointment":
    create_appointment()
