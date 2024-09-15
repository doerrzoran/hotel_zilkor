import logo from '../assets/images/logo_zilkor_3.png'
import menu from '../assets/images/menu.png'
import Connect from './pages/divers/Connect'



export default function Header() {
    

    return(
        <>
        <header>
            <div id='logo'>
                <img className='logo' src={logo} alt="logo of Zilkor" />
            </div>
            <div id='user'>
                <Connect/>
            </div>
            <div id='dropdownMenue'>
                <img className='menuIcon' src={menu} alt="icone dropdown menue" />
                <nav className='navDesktop'>
                    <a href="/">Accueil</a>
                    <a href="#">Réserver une chambre</a>
                    <a href="#">A propos de nous</a>
                    <a href="#">Contact</a>
                </nav>
            </div>
        </header>   
        </>
    )  
}
