import axios from 'axios';
import XHRAdapter from 'axios/lib/adapters/xhr';

const customAxios = axios.create({
  adapter: XHRAdapter
});

export default customAxios;
