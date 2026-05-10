import subprocess
from concurrent.futures import ThreadPoolExecutor

def ping(ip):
    command = ['ping', '-n', '1', ip]
    return ip, subprocess.call(command) == 0

def main():
    base_ip = "172.22."  # サブネットのベース部分
    results = []
    
    # base_ip.. までの範囲
    for third_octet in range(23,28): 
        for fourth_octet in range(256):  # 0 から 255
            ip = f"{base_ip}{third_octet}.{fourth_octet}"
            results.append(ip)

    reachable_results = []

    with ThreadPoolExecutor(max_workers=300) as executor:
        for ip, reachable in executor.map(ping, results):
            reachable_results.append((ip, reachable))

    # # 最後に結果を整理して表示
    # for ip, reachable in reachable_results:
    #     if reachable:
    #         print(f"{ip} is reachable")
    #     else:
    #         print(f"{ip} is not reachable")

if __name__ == "__main__":
    main()
