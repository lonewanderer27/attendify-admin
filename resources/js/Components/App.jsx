import { useQuery, QueryClient, QueryClientProvider } from "react-query";
const queryClient = new QueryClient();

export function App({ children }) {
  return (
    <QueryClientProvider client={queryClient}>
      {children}
    </QueryClientProvider>
  )
}