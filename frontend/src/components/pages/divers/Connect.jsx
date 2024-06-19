import account from '../../../assets/images/bouton-de-compte-rond-avec-lutilisateur-a-linterieur.png'

export default function Connect() {
    return(
        <>
            <div id="dropdownIcon">
            <div className="connect">
                <button className="login-btn">
                <img className="accountIcon" src={account} alt="logo of Zilkor" />
                <span className="username">connection</span>
                </button>
            </div>
            </div>
        </>         
    )
}
