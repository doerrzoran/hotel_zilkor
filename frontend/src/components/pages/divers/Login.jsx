
import { useState } from 'react';
import { usePostLoginMutation } from '../../../slices/ApiSlice';
import { useNavigate } from 'react-router-dom';

export default function Login() {
  const [email, setEmail] = useState('');
  const [password, setPassword] = useState('');
  const [login, { isLoading, error, isSuccess }] = usePostLoginMutation();
  const navigate = useNavigate();

  const handleSubmit = async (event) => {
    event.preventDefault();
    const result = await login({ email, password });
    if (result.data && result.data.token) {
      localStorage.setItem('jwtToken', result.data.token);
      // console.log('Token stored:', result.data.token);
      navigate('/')
      location.reload()
    }
  };

  return (
    <div>
      {
         isSuccess ? <div>success</div> :
      <form onSubmit={handleSubmit}>
        <label htmlFor="email">Email:</label>
        <input
          type="text"
          id="email"
          name="email"
          value={email}
          onChange={(event) => setEmail(event.target.value)}
        />

        <label htmlFor="password">Password:</label>
        <input
          type="password"
          id="password"
          name="password"
          value={password}
          onChange={(event) => setPassword(event.target.value)}
        />

        <button type="submit" disabled={isLoading}>
          {isLoading ? 'Loading...' : 'Login'}
        </button>

        {error && <p>{error.error}</p>}
      </form>
      }
    </div>
  );
}
