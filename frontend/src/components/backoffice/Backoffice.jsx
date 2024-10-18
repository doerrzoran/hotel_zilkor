import { Link, useNavigate } from 'react-router-dom';
import { useGetMeQuery } from '../../slices/ApiSlice';
import { useEffect } from 'react';

export default function Backoffice(props) {
  const { content } = props
  const { data, error, isLoading, refetch } = useGetMeQuery()
  const navigate = useNavigate();

  const handleLogout = () => {
    localStorage.removeItem('jwtToken')
    location.reload()
}

  useEffect(() => {
    if (!isLoading) {
      if (!data || !data.role || !data.role.includes('ROLE_ADMIN')) {
        // If the data is fetched and the role isn't admin, redirect
        navigate('/');
      }
    }
  }, [data, isLoading, navigate]);

  return (
    <>
     
      <nav className='backofficeNav'>
        <Link to="/backoffice/rooms">Chambres</Link>
        <Link to="/backoffice/hostels">Hotels</Link>
        <Link to="/backoffice/bookings">Bookings</Link>
        <Link to="/backoffice/guests">guests</Link>
        <button onClick={handleLogout}>Logout</button>     
      </nav>
      {
        content
      }
    </>
  );
}
