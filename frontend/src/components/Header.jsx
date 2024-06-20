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
