export interface User {
  id: number;
  alias: string;
  role: 'admin' | 'profesor';
}