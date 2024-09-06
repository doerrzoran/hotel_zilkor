import { Link } from 'react-router-dom';

export default function Backoffice() {
  return (
    <>
      <Link to="/backoffice/rooms">Chambres</Link>
      <Link to="/backoffice/hostels">Hotels</Link>
      <Link to="/backoffice/bookings">Bookings</Link>
    </>
  );
}
