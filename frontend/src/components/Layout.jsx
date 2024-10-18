// import Footer from "./Footer";
import Header from "./Header";

export default function Layout(props) {
    let {content} = props
    return(
        <>
            <Header/>
            <main>
                {
                    content
                }
            </main>
            {/* <Footer/> */}
        </>
    )
}
