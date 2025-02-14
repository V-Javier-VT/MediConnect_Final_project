import streamlit as st
import requests
import time

# Configuración de la página de Streamlit
st.set_page_config(page_title="Sistema de Gestión Médica", page_icon="🏥")

# Variables de sesión
if "token" not in st.session_state:
    st.session_state.token = None
if "authenticated" not in st.session_state:
    st.session_state.authenticated = False
if "page" not in st.session_state:
    st.session_state.page = "login"

def login_page():
    st.subheader("🔐 Iniciar Sesión")
    email = st.text_input("Correo Electrónico", placeholder="Ingrese su correo electrónico")
    password = st.text_input("Contraseña", type="password", placeholder="Ingrese su contraseña")
    
    if st.button("Iniciar sesión"):
        if email and password:
            url = "http://107.21.146.69:1001/auth/login"
            data = {"email": email, "password": password}
            
            try:
                response = requests.post(url, json=data)
                if response.status_code == 200:
                    st.success("Inicio de sesión exitoso")
                    time.sleep(1.5)
                    
                    # Guardar token y estado de autenticación
                    response_data = response.json()
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

def register_page():
    st.subheader("📝 Registrar Usuario")
    name = st.text_input("Nombre Completo")
    email = st.text_input("Correo Electrónico")
    password = st.text_input("Contraseña", type="password")
    
    if st.button("Registrar"):
        url = "http://107.21.146.69:6001/create-user-service/users/create"
        data = {
            "name": name,
            "email": email,
            "password": password,
            "role": "admin",  # Se establece automáticamente como administrador
            "reference_id": 999  # Valor fijo, no visible para el usuario
        }
        
        response = requests.post(url, json=data)
        if response.status_code == 201:
            st.success("Usuario registrado exitosamente")
            time.sleep(1.5)
            st.session_state.page = "login"
            st.rerun()
        else:
            st.error(f"Error al registrar usuario: {response.text}")
    
    if st.button("Volver a Login"):
        st.session_state.page = "login"
        st.rerun()

def dashboard():
    st.subheader("📋 Panel de Administración")
    st.write("Seleccione una opción:")
    
    if st.button("Cerrar Sesión"):
        st.session_state.token = None
        st.session_state.authenticated = False
        st.session_state.page = "login"
        st.rerun()

# Manejo de Navegación
if st.session_state.page == "login":
    login_page()
elif st.session_state.page == "register":
    register_page()
elif st.session_state.page == "dashboard":
    dashboard()
