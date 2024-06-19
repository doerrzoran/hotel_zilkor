import logo from '../assets/images/logo_zilkor_3.png'
import menu from '../assets/images/menu.png'
import account from '../assets/images/bouton-de-compte-rond-avec-lutilisateur-a-linterieur.png'
import { useContext, useEffect, useState } from 'react'
import { UserContext } from '../context/UserContext'
import { useGetMeQuery } from '../slices/ApiSlice'


export default function Header() {
    const { data, error, isLoading, refetch } = useGetMeQuery()
    const [username, setUsername] = useState('connexion')
    

    useEffect(()=>{
        if (data && data.username) {          
            setUsername(data.username)
        }
    }, [data])

    return(
        <>
        <header>
            <div id='logo'>
                <img className='logo' src={logo} alt="logo of Zilkor" />
            </div>
            <button className='Login'>
            <img className='accountIcon' src={account} alt="accountIcon" />
            <p className='user'>
                {
                    isLoading ? '' : username
                }
            </p>
            </button>
            <div id='dropdownMenue'>
                <img className='menuIcon' src={menu} alt="icone dropdown menue" />
                <nav className='navDesktop'>
                    <a href="">acceuil</a>
                    <a href="">reserver une chambre</a>
                    <a href="">à propos de nous</a>
                    <a href="">contacts</a>
                </nav>
            </div>
        </header>   
        </>
    )  
}
