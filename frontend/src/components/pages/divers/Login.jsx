
import { useState } from 'react';
import { usePostLoginMutation } from '../../../slices/ApiSlice';

export default function Login() {
  const [username, setUsername] = useState('');
  const [password, setPassword] = useState('');
  const [login, { isLoading, error, isSuccess }] = usePostLoginMutation();

  const handleSubmit = async (event) => {
    event.preventDefault();
    const result = await login({ username, password });
    if (result.data && result.data.token) {
      localStorage.setItem('jwtToken', result.data.token);
      console.log('Token stored:', result.data.token);
    }
  };

  return (
    <div>
      {
         isSuccess ? <div>success</div> :
      <form onSubmit={handleSubmit}>
        <label htmlFor="username">Email:</label>
        <input
          type="text"
          id="username"
          name="username"
          value={username}
          onChange={(event) => setUsername(event.target.value)}
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
