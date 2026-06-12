// 小程序端统一域名配置：部署前只需要修改这里。
const APP_DOMAIN = 'https://demo.wmj.com.cn';

const trimEndSlash = (value) => String(value || '').replace(/\/+$/, '');
const normalizePath = (path) => {
	const value = String(path || '');
	return value.startsWith('/') ? value : `/${value}`;
};

const domainUrl = trimEndSlash(APP_DOMAIN);
const apiUrl = `${domainUrl}/api`;

export const softwareDomainUrl = domainUrl;
export const softwareApiUrl = `${softwareDomainUrl}/api`;
export const normalizeCamWebBase = (baseUrl = '') => {
	const value = trimEndSlash(baseUrl || `${domainUrl}/camweb/`);
	return value || `${domainUrl}/camweb`;
};
export const assetUrl = (path = '') => `${domainUrl}${normalizePath(path)}`;
export const camWebUrl = (hashPath = '/', params = {}, baseUrl = '') => {
	const camWebBase = normalizeCamWebBase(baseUrl);
	const cleanHashPath = String(hashPath || '/').startsWith('/') ? String(hashPath || '/') : `/${hashPath}`;
	const cacheVersion = params.t || Date.now();
	const query = Object.keys(params)
		.filter((key) => key !== 't' && params[key] !== undefined && params[key] !== null && params[key] !== '')
		.map((key) => `${encodeURIComponent(key)}=${encodeURIComponent(params[key])}`)
		.join('&');

	return `${camWebBase}/?v=${encodeURIComponent(cacheVersion)}#${cleanHashPath}${query ? `?${query}` : ''}`;
};

export { domainUrl, apiUrl };
