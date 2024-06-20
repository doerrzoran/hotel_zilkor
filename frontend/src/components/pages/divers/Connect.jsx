import account from '../../../assets/images/bouton-de-compte-rond-avec-lutilisateur-a-linterieur.png'
import { useEffect, useState } from 'react'
import { useGetMeQuery } from '../../../slices/ApiSlice'
import { useNavigate } from 'react-router-dom';

export default function Connect() {
    const { data, error, isLoading, refetch } = useGetMeQuery()
    const [showDropdown, setShowDropdown] = useState(false);
    const [username, setUsername] = useState()
    const navigate = useNavigate();

    useEffect(()=>{
        if (data && data.username) {          
            setUsername(data.username)
        }
    }, [data])

    const handleClick = () => {
        setShowDropdown(!showDropdown)
    }

    const handleLogin = () => {
        navigate('/login');
    }

    return(
        <>
            <button className='Login' onClick={handleClick}>
                <img className='accountIcon' src={account} alt="accountIcon" />
                <p className='user'>
                    {
                        error ? <p>connexion</p> : 
                        username
                    }
                </p>
                </button>
                {showDropdown && (
                <div id='dropdownConnect'>
                    <button className='Connection' onClick={handleLogin}>Connection</button>
                    <button className='CreateAccount'>Inscription</button>
                </div>

                )}
        </>         
    )
}
