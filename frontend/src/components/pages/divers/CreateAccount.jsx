import { useEffect, useState } from 'react';
import { usePostRegisterMutation, usePostLoginMutation } from '../../../slices/ApiSlice';
import { useNavigate } from 'react-router-dom';
import CGU from './CGU';

export default function CreateAccount() {
    const [formData, setFormData] = useState({ email: '', plainPassword: '', agreeTerms: false });
    const [register, { isLoading: isRegisterLoading, isError: isRegisterError, error: registerError }] = usePostRegisterMutation();
    const [login, { isLoading: isLoginLoading, error: loginError, isSuccess: isLoginSuccess }] = usePostLoginMutation();
    const navigate = useNavigate();
    const [showCGU, setShowCGU] = useState(false);
    const [errorMessage, setErrorMessage] = useState('');
    const Modal = ({ isOpen, onClose, children }) => {
        if (!isOpen) return null;
      
        return (
          <div className="modal-overlay">
            <div className="modal-content">
              <button className="modal-close" onClick={onClose}>X</button>
              {children}
            </div>
          </div>
        );
      };
      

    const handleChange = (e) => {
        const { name, value, checked, type } = e.target;
        const val = type === 'checkbox' ? checked : value;
        setFormData((prevData) => ({
            ...prevData,
            [name]: val,
        }));
    };

    const handleSubmit = async (e) => {
        e.preventDefault();
        try {
            const registerResult = await register(formData).unwrap();
            if (!registerResult.isError) {
                const loginResult = await login({ email: formData.email, password: formData.plainPassword }).unwrap();
                if (loginResult.token) {
                    localStorage.setItem('jwtToken', loginResult.token);
                    navigate('/'); 
                    location.reload()
                }
            }
        } catch (err) {
            if(err.data.plainPassword){
                setErrorMessage('mot de passe invalide');
            }
            if(err.data.message){
                setErrorMessage(err.data.message);
            }
            
        }
    };



    return (
        <>
            <article className='formContainer'>
            {registerError && <p>{registerError.error}</p>}
            {errorMessage && <p className="error-message">{errorMessage}</p>}
                <h2>Créez un compte</h2>
                <form onSubmit={handleSubmit}>
                    <label>
                        Email:
                        <input type="email" name="email" value={formData.email} onChange={handleChange}  required/>
                    </label>
                    <label>
                        Mot de passe:
                        <input type="password" name="plainPassword" value={formData.plainPassword} onChange={handleChange} required />
                    </label>
                    <label>
                        accepter les conditions d'utilisations:
                        <input type="checkbox" name="agreeTerms" checked={formData.agreeTerms} onChange={handleChange} required />
                    </label>
                    <a href="#" onClick={(e) => { e.preventDefault(); setShowCGU(true); }}>
                            voir les conditions générales d'utilisation
                        </a>                    
                        <button type="submit" disabled={isRegisterLoading || isLoginLoading}>Register</button>
                    
                </form>
            </article>
                <Modal isOpen={showCGU} onClose={() => setShowCGU(false)}>
                    <CGU />
                </Modal>
        </>
    );
}
