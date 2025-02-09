import streamlit as st
import requests

# Configuración de la página de Streamlit
st.set_page_config(page_title="Login", page_icon="🔑")

st.title("🔐 Sistema de Autenticación")

# Formulario de autenticación
def login_page():
    email = st.text_input("Correo Electrónico", placeholder="Ingrese su correo electrónico")
    password = st.text_input("Contraseña", type="password", placeholder="Ingrese su contraseña")

    # Botón para enviar la solicitud de login
    if st.button("Iniciar sesión"):
        if email and password:
            url = "http://localhost:1001/auth-user-service/auth/login"
            data = {"email": email, "password": password}
            
            try:
                response = requests.post(url, json=data)
                if response.status_code == 200:
                    response_data = response.json()
                    st.success("Inicio de sesión exitoso")
                    st.json(response_data)  # Muestra la respuesta del servidor
                    
                    # Guardar respuesta en una cookie
                    st.experimental_set_query_params(token=response_data.get("token"))
                else:
                    st.error(f"Error: {response.status_code} - {response.text}")
            except requests.exceptions.RequestException as e:
                st.error(f"Error de conexión: {e}")
        else:
            st.warning("Por favor, ingrese correo electrónico y contraseña")

    if st.button("Registrar Usuario"):
        st.session_state.page = "register"
        st.rerun()

# Página de registro
def register_page():
    st.subheader("📝 Registro de Usuario")
    name = st.text_input("Nombre Completo", placeholder="Ingrese su nombre completo")
    email = st.text_input("Correo Electrónico", placeholder="Ingrese su correo electrónico")
    password = st.text_input("Contraseña", type="password", placeholder="Ingrese su contraseña")
    role = st.selectbox("Rol", ["patient", "doctor", "admin"])
    
    if st.button("Crear Cuenta"):
        url = "http://localhost:6001/create-user-service/users/create"
        
        # Obtener el siguiente ID automáticamente
        ref_id_response = requests.get("http://localhost:6001/create-user-service/users/next-id")
        if ref_id_response.status_code == 200:
            reference_id = ref_id_response.json().get("next_id", 1)
        else:
            reference_id = 1
        
        data = {
            "name": name,
            "email": email,
            "password": password,
            "role": role,
            "reference_id": reference_id
        }
        
        try:
            response = requests.post(url, json=data)
            if response.status_code == 201:
                st.success("Usuario registrado exitosamente. Redirigiendo a login...")
                st.session_state.page = "login"
                st.rerun()
            else:
                st.error(f"Error al registrar: {response.status_code} - {response.text}")
        except requests.exceptions.RequestException as e:
            st.error(f"Error de conexión: {e}")
    
    if st.button("Volver a Login"):
        st.session_state.page = "login"
        st.rerun()

# Manejo de navegación entre pantallas
if "page" not in st.session_state:
    st.session_state.page = "login"

if st.session_state.page == "login":
    login_page()
elif st.session_state.page == "register":
    register_page()
