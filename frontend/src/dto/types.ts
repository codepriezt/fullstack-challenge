export interface IWeather {
  base?: string;
  main_grnd_level?: number;
  main_humidity?: number;
  main_pressure?: number;
  main_sea_level?: number;
  main_temp_min?: string;
  main_temp_max?: string;
  sys_sunrise?: number;
  sys_sunsset?: number;
  temp?: string;
  timezone?: number;
  visibility?: number;
  weather?: string;
  wind_dog?: string;
  weather_description?: string;
  wind_deg?: string;
  wind_gust: string;
  wind_speed?: string;
  updatedAt: string;
}

export interface IDataSource {
  id: number;
  name: string;
  email: string;
  latitude: string;
  longitude: string;
  weather?: IWeather;
}

export interface ITableData {
  id: number;
  name: string;
  email: string;
  latitude: string;
  longitude: string;
  weather: string;
  description: string;
  updatedAt: string;
}

export interface IColumn {
  title: string;
  dataIndex: string;
  key: string;
  scopedSlots: { customRender: string };
}
