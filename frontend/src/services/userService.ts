const baseUrl = import.meta.env.VITE_BACKEND_SERVER_URL;

export const fetchUsers = async (page: number): Promise<any> => {
  let users;
  const response = await fetch(`${baseUrl}/users?page=${page}`, {
    mode: "cors",
  });

  if (response.ok) users = await response.json();

  if (users?.status) {
    return Promise.resolve({
      status: true,
      data: users?.data,
      meta: {
        currentPage:users?.meta?.current_page,
        lastPage: users?.meta?.last_page,
        pageSize:users?.links?.pageSize,
        total: users?.links?.total,
      },
    });
  } else {
    return Promise.reject({
      status: false,
      data: null,
      meta: null,
    });
  }
};
