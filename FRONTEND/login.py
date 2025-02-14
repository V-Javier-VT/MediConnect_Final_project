import streamlit as st
import requests
import time

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
    st.subheader("🔒 Iniciar Sesión")
    email = st.text_input("Correo Electrónico", placeholder="Ingrese su correo electrónico")
    password = st.text_input("Contraseña", type="password", placeholder="Ingrese su contraseña")

    if st.button("Iniciar sesión"):
        if email and password:
            url = "http://107.21.146.69:1001/auth/login"
            data = {"email": email, "password": password}
            
            try:
                response = requests.post(url, json=data)
                if response.status_code == 200:
                    response_data = response.json()
                    st.success("Inicio de sesión exitoso")
                    time.sleep(1.5)
                    
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
    
    if st.button("Registrarse"):
        st.session_state.page = "register"
        st.rerun()

# Función para registrar usuario
def register_page():
    st.subheader("👤 Registrar Usuario")
    name = st.text_input("Nombre Completo")
    email = st.text_input("Correo Electrónico")
    password = st.text_input("Contraseña", type="password")

    if st.button("Crear Usuario"):
        url = "http://107.21.146.69:6001/create-user-service/users/create"
        data = {
            "name": name,
            "email": email,
            "password": password,
            "role": "admin",
            "reference_id": 9999  # Valor fijo oculto
        }
        response = requests.post(url, json=data)
        if response.status_code == 201:
            st.success("Usuario creado exitosamente")
            st.session_state.page = "login"
            st.rerun()
        else:
            st.error(f"Error al crear usuario: {response.text}")
    
    if st.button("Volver"):
        st.session_state.page = "login"
        st.rerun()

# Función para mostrar el dashboard
def dashboard():
    st.subheader("📜 Panel de Administración")

    col1, col2 = st.columns(2)

    with col1:
        if st.button("Pacientes"):
            st.session_state.page = "patients"
            st.rerun()

    if st.button("Cerrar Sesión"):
        st.session_state.token = None
        st.session_state.authenticated = False
        st.session_state.page = "login"
        st.rerun()

# Función para gestionar pacientes
def manage_patients():
    st.subheader("Gestionar Pacientes")

    # Crear Paciente
    with st.expander("➕ Añadir Paciente"):
        name = st.text_input("Nombre Completo")
        age = st.number_input("Edad", min_value=0)
        gender = st.selectbox("Género", ["Masculino", "Femenino", "Otro"])
        email = st.text_input("Correo Electrónico")

        if st.button("Guardar Paciente"):
            url = "http://18.211.59.226:3005/api/patients"
            headers = {"Authorization": f"Bearer {st.session_state.token}"}
            data = {"name": name, "age": age, "gender": gender, "email": email}
            response = requests.post(url, json=data, headers=headers)
            if response.status_code == 201:
                st.success("Paciente creado exitosamente")
            else:
                st.error(f"Error al crear paciente: {response.text}")
    
    # Volver al menú
    if st.button("Volver"):
        st.session_state.page = "dashboard"
        st.rerun()

# Manejo de Navegación
if st.session_state.page == "login":
    login_page()
elif st.session_state.page == "register":
    register_page()
elif st.session_state.page == "dashboard":
    dashboard()
elif st.session_state.page == "patients":
    manage_patients()
