import { useState } from 'react';
import { usePostRegisterMutation, usePostLoginMutation } from '../../../slices/ApiSlice';
import { useNavigate } from 'react-router-dom';

export default function CreateAccount() {
    const [formData, setFormData] = useState({ email: '', plainPassword: '', agreeTerms: false });
    const [register, { isLoading: isRegisterLoading, isError: isRegisterError, error: registerError }] = usePostRegisterMutation();
    const [login, { isLoading: isLoginLoading, error: loginError, isSuccess: isLoginSuccess }] = usePostLoginMutation();
    const navigate = useNavigate();

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
            alert('echec de l\'inscription')
        }
    };

    return (
        <>
            <h2>Create Account</h2>
            <form onSubmit={handleSubmit}>
                <label>
                    Email:
                    <input type="email" name="email" value={formData.email} onChange={handleChange} required />
                </label>
                <label>
                    Password:
                    <input type="password" name="plainPassword" value={formData.plainPassword} onChange={handleChange} required />
                </label>
                <label>
                    Agree to terms:
                    <input type="checkbox" name="agreeTerms" checked={formData.agreeTerms} onChange={handleChange} required />
                </label>
                <button type="submit" disabled={isRegisterLoading || isLoginLoading}>Register</button>
                {isRegisterError && <div>Error: {registerError.message}</div>}
                {loginError && <div>Error: {loginError.error}</div>}
            </form>
        </>
    );
}
