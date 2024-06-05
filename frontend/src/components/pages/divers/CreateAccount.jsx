import React, { useState } from 'react';
import { usePostRegisterMutation } from '../../../slices/ApiSlice';

export default function CreateAccount() {
    const [formData, setFormData] = useState({ email: '', plainPassword: '', agreeTerms: false });
    const [register, { isLoading, isError, error }] = usePostRegisterMutation();

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
            await register(formData);
            // Handle success, maybe redirect or show a success message
        } catch (err) {
            // Handle error, display error message
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
                <button type="submit" disabled={isLoading}>Register</button>
                {isError && <div>Error: {error.message}</div>}
            </form>
        </>
    );
}
