import account from '../../../assets/images/bouton-de-compte-rond-avec-lutilisateur-a-linterieur.png'
import { useEffect, useState } from 'react'
import { useGetMeQuery } from '../../../slices/ApiSlice'
import { Link, useNavigate } from 'react-router-dom';

export default function Connect() {
    const { data, error, isLoading, refetch } = useGetMeQuery()
    const [username, setUsername] = useState()
    const [role, setRole] = useState('')
    const isAdmin = role.includes("ROLE_ADMIN")
    const navigate = useNavigate();

    useEffect(()=>{
        if (data && data.username) {          
            setUsername(data.username)
            if (data && data.role) {          
                setRole(data.role)
                console.log(role)
            }
        }
    }, [data, role])


    const handleLogin = () => {
        navigate('/login');
    }
    const handleLogout = () => {
        localStorage.removeItem('jwtToken')
        location.reload()
        navigate('/')
    }

    const handleRegister = () => {
        navigate('/new/account');
    }

    return(
        <>
            <button className='Login'>
                <img className='accountIcon' src={account} alt="accountIcon" />
                <div className='user'>
                    {
                        error ? <p>connection</p> : 
                        username
                    }
                </div>
                </button>
                
                <div id='dropdownConnect'>
                    {
                        error ?
                        <>
                            <button className='Connection' onClick={handleLogin}>Connection</button>
                            <button className='CreateAccount' onClick={handleRegister}>Inscription</button>
                        </>
                        :
                        isAdmin ?
                        <>
                            <a href="/Backoffice/hostels">Backoffice</a>
                            <button onClick={handleLogout}>Logout</button>
                        </>
                        :
                        <>
                            <a href="/my/booking">vos reservations</a>
                            <button onClick={handleLogout}>Logout</button>
                        </>
                        }
                </div>

                
        </>         
    )
}
